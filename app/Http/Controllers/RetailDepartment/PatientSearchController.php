<?php

namespace App\Http\Controllers\RetailDepartment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class PatientSearchController extends Controller
{
    /**
     * Display the patient search page
     */
    public function index()
    {
        return view('retail_dept.retail_search');
    }

    /**
     * Search for patients/members by IC, name, or MRN
     */
    public function search(Request $request)
    {
        $searchType = $request->input('search_type');
        $query = $request->input('query');

        $members = [];

        if ($query && strlen($query) >= 3) {
            if ($searchType === 'ic') {
                $members = Member::where('member_nric', 'LIKE', "%{$query}%")
                    ->take(5)
                    ->get();
            } elseif ($searchType === 'mrn') {
                $members = Member::where('member_mrn', 'LIKE', "%{$query}%")
                    ->take(5)
                    ->get();
            } else {
                $members = Member::where('member_name', 'LIKE', "%{$query}%")
                    ->take(5)
                    ->get();
            }
        }

        return response()->json($members);
    }

    /**
     * Get detailed information about a specific member
     */
    public function getMemberDetails($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }
}
