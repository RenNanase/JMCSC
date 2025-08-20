<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Imports\PatientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mrn', 'like', "%{$search}%")
                  ->orWhere('Nationality_ID', 'like', "%{$search}%");
            });
        }

        // Use pagination with reasonable page size to prevent memory issues
        $patients = $query->latest()->paginate(6)->withQueryString();

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mrn' => 'required|string|max:255|unique:patients,mrn',
            'Nationality_ID' => 'nullable|string|max:255|unique:patients,Nationality_ID',
        ]);

        Patient::create($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mrn' => 'required|string|max:255|unique:patients,mrn,' . $patient->id,
            'Nationality_ID' => 'nullable|string|max:255|unique:patients,Nationality_ID,' . $patient->id,
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Log::info('Starting patient import process');

            // Increase memory limit and execution time
            ini_set('memory_limit', '1024M'); // Increased to 1GB
            set_time_limit(0); // No time limit

            $import = new \App\Imports\LargePatientsImport;

            // Import with progress bar and ensure all rows are processed
            Excel::import($import, $request->file('file'));

            // Get import statistics
            $totalImported = $import->getRowCount();
            $skippedRows = $import->getSkippedRows();
            $totalRows = $totalImported + $skippedRows;

            Log::info('Import completed', [
                'total_rows' => $totalRows,
                'imported' => $totalImported,
                'skipped' => $skippedRows
            ]);

            return redirect()->route('admin.patients.index')
                ->with('success', "Import completed successfully!\nTotal rows processed: {$totalRows}\nSuccessfully imported: {$totalImported}\nSkipped rows: {$skippedRows}");
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $request->file('file')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.patients.index')
                ->with('error', 'Error importing patients: ' . $e->getMessage());
        }
    }

    //api

// {
//     // API 1: Fetch Status=0 (Pending)
//     public function index()
//     {
//         $apiResponse = Http::get('https://healthform.jmc.my/healthform/public/api/sc');
//         $members = $apiResponse->json();

//         return view('members.index', ['members' => $members]);
//     }

//     // API 4: Fetch Status=2 (Unverified)
//     public function unverified()
//     {
//         $apiResponse = Http::get('https://healthform.jmc.my/healthform/public/api/unverifiedsc');
//         $members = $apiResponse->json();

//         return view('members.unverified', ['members' => $members]);
//     }

//     // API 2: Verify (Status=1)
//     public function verify($id)
//     {
//         // Update remote system
//         Http::put("https://healthform.jmc.my/healthform/public/api/sc/{$id}/activate");

//         // Update local DB (if applicable)
//         Member::where('id', $id)->update(['status' => 1]);

//         return redirect()->back()->with('success', 'Member verified!');
//     }

//     // API 3: Reject (Status=2)
//     public function reject($id)
//     {
//         // Update remote system
//         Http::put("https://healthform.jmc.my/healthform/public/api/sc/{$id}/unverified");

//         // Update local DB
//         Member::where('id', $id)->update(['status' => 2]);

//         return redirect()->back()->with('error', 'Member rejected!');
//     }
// }
}
