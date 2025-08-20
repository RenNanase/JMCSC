<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientSearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            // Log the incoming request
            Log::info('Patient search request received', [
                'query' => $request->input('query'),
                'headers' => $request->headers->all(),
                'method' => $request->method(),
                'url' => $request->fullUrl()
            ]);

            $query = $request->input('query');

            if (empty($query)) {
                Log::info('Empty query received, returning empty array');
                return response()->json([]);
            }

            // Log the search query
            Log::info('Processing search query', ['query' => $query]);

            // Split the search term into words
            $searchTerms = explode(' ', trim($query));
            Log::info('Search terms', ['terms' => $searchTerms]);

            $patientsQuery = Patient::query();

            foreach ($searchTerms as $term) {
                $patientsQuery->where(function($q) use ($term) {
                    $q->where('Name', 'like', '%' . $term . '%')
                      ->orWhere('MRN', 'like', '%' . $term . '%')
                      ->orWhere('Nationality_ID', 'like', '%' . $term . '%');
                });
            }

            // Log the SQL query
            Log::info('SQL Query', [
                'sql' => $patientsQuery->toSql(),
                'bindings' => $patientsQuery->getBindings()
            ]);

            $patients = $patientsQuery->limit(10)->get(['id', 'Name', 'MRN', 'Nationality_ID']);

            // Log the results
            Log::info('Search results', [
                'count' => $patients->count(),
                'results' => $patients->toArray()
            ]);

            return response()->json($patients);

        } catch (\Exception $e) {
            // Log detailed error information
            Log::error('Patient search error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'query' => $request->input('query'),
                'request_data' => $request->all()
            ]);

            // For debugging, you can uncomment this line to see the error in the response
            // return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);

            return response()->json([
                'error' => 'An error occurred while searching patients',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
