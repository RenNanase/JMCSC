<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;

class EventMemberController extends Controller
{
    // Show pending members (Status=0)
    public function index()
    {
        $response = \Illuminate\Support\Facades\Http::get('https://healthform.jmc.my/healthform/public/api/sc');
        $members = $response->json();
        Log::info('API members response', ['members' => $members]);

        // Fetch all patients' Nationality_ID and MRN
        $patients = \App\Models\Patient::pluck('MRN', 'Nationality_ID');
        foreach ($members as &$member) {
            $nrid = $member['nrid'] ?? null;
            if ($nrid && $patients->has($nrid)) {
                $member['is_patient'] = true;  //yes
                $member['patient_mrn'] = $patients[$nrid];
            } else {
                $member['is_patient'] = false; //no
                $member['patient_mrn'] = null;
            }

            // Check if user is already a member
            if ($nrid) {
                $member['is_existing_member'] = \App\Models\Member::where('member_nric', $nrid)->exists();
            } else {
                $member['is_existing_member'] = false;
            }
        }
        unset($member);

        // Sort members by latest first (assuming they have an 'id' field that indicates order)
        usort($members, function($a, $b) {
            return ($b['id'] ?? 0) - ($a['id'] ?? 0);
        });

        // Paginate the results to show only 10 members per page
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedMembers = array_slice($members, $offset, $perPage);

        // Create a custom paginator instance
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedMembers,
            count($members),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.eventMembers.index', compact('members', 'paginator'));
    }

    // Verify member (Status=1)
    public function verify($id)
    {
        // Fetch the member's data from the pending list BEFORE verifying
        $response = \Illuminate\Support\Facades\Http::get('https://healthform.jmc.my/healthform/public/api/sc');
        $members = $response->json();
        Log::info('API members response', ['members' => $members, 'search_id' => $id]);
        $memberData = collect($members)->firstWhere('id', (string)$id);
        $patientMRN = \App\Models\Patient::where('Nationality_ID', $memberData['nrid'])->value('MRN');

        Log::info('Member data for verification', ['memberData' => $memberData]);

        if ($memberData) {
            Log::info('Checking if member exists', ['member_nric' => $memberData['nrid']]);
            $exists = \App\Models\Member::where('member_nric', $memberData['nrid'])->exists();
            if (!$exists) {
                Log::info('Creating new member', [
                    'member_name'   => $memberData['fullname'] ?? null,
                    'member_nric'   => $memberData['nrid'] ?? null,
                    'member_gender' => $memberData['gender'] ?? null,
                ]);
                \App\Models\Member::create([
                    'member_name'      => $memberData['fullname'] ?? null,
                    'member_nric'      => $memberData['nrid'] ?? null,
                    'member_gender'    => $memberData['gender'] ?? null,
                    'member_phoneNum'  => $memberData['phonenumber'] ?? '', //fix phone num - nric
                    'member_dob'       => $memberData['dob'] ?? '',
                    'member_address'       => $memberData['address'] ?? '', //fix address - dob
                    'member_email'       => $memberData['email'] ?? '',   //fix email - name
                    'member_mrn' => $patientMRN ?? '',

                ]);
            }
        }

        // verify the member in the system
        $api = \Illuminate\Support\Facades\Http::put("https://healthform.jmc.my/healthform/public/api/sc/{$id}/activate");

        return redirect()->route('admin.eventMembers.index')->with('success', 'Member verified and registered!');
    }

    // Reject member (Status=2)
    public function reject($id)
    {
        $api = Http::put("https://healthform.jmc.my/healthform/public/api/sc/{$id}/unverified");
        // Optionally update local DB if needed
        return redirect()->route('admin.eventMembers.index')->with('error', 'Member rejected!');
    }

    // Show unverified members (Status=2)
    public function unverified()
    {
        $response = \Illuminate\Support\Facades\Http::get('https://healthform.jmc.my/healthform/public/api/unverifiedsc');
        $members = $response->json();
        Log::info('API members response', ['members' => $members]);

        // Fetch all patients' Nationality_ID and MRN
        $patients = \App\Models\Patient::pluck('MRN', 'Nationality_ID');
        foreach ($members as &$member) {
            $nrid = $member['nrid'] ?? null;
            if ($nrid && $patients->has($nrid)) {
                $member['is_patient'] = true;
                $member['patient_mrn'] = $patients[$nrid];
            } else {
                $member['is_patient'] = false;
                $member['patient_mrn'] = null;
            }

            // Check if user is already a member
            if ($nrid) {
                $member['is_existing_member'] = \App\Models\Member::where('member_nric', $nrid)->exists();
            } else {
                $member['is_existing_member'] = false;
            }
        }
        unset($member);

        // Sort members by latest first (assuming they have an 'id' field that indicates order)
        usort($members, function($a, $b) {
            return ($b['id'] ?? 0) - ($a['id'] ?? 0);
        });

        // Paginate the results to show only 10 members per page
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedMembers = array_slice($members, $offset, $perPage);

        // Create a custom paginator instance
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedMembers,
            count($members),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.eventMembers.unverified', compact('members', 'paginator'));
    }
}
