<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class MembershipController extends Controller
{
    /**
     * Display the marketing dashboard with member statistics
     */
    public function dashboard()
    {
        $totalMembers = Member::count();
        $newThisMonth = Member::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $activeMembers = Member::where('is_active', true)->count();

        $userName = Auth::user()->name;

        return view('marketing.dashboard', compact('totalMembers', 'newThisMonth', 'activeMembers', 'userName'));
    }

    /**
     * Display the member registration form.
     */
    public function registration()
    {
        return view('marketing.membership.registration');
    }

    /**
     * Display the list of members.
     */
    public function list(Request $request)
    {
        $query = Member::query()->with('registeredBy');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('member_name', 'like', "%{$search}%")
                  ->orWhere('member_nric', 'like', "%{$search}%")
                  ->orWhere('member_mrn', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(6)->withQueryString();
        return view('marketing.membership.list', compact('members'));
    }

    /**
     * Display the specified member details.
     */
    public function show($id)
    {
        $member = Member::with('registeredBy')->findOrFail($id);
        return view('marketing.membership.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('marketing.membership.edit', compact('member'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'member_name' => 'required|string|max:255',
            'member_nric' => 'required|string|max:20|unique:members,member_nric,'.$id,
            'member_mrn' => 'nullable|string|max:20|unique:members,member_mrn,'.$id,
            'member_email' => 'nullable|email|max:255',
            'member_phoneNum' => 'required|string|max:20',
            'member_gender' => 'required|in:Male,Female',
            'member_address' => 'nullable|string',
            'member_dob' => 'required|date',
            'is_active' => 'boolean',
            'is_ecard_given' => 'boolean',
        ]);

        $member->update($request->except(['member_emergencyContactName', 'member_emergencyContactPhone', 'member_medicalConditions']));

        return redirect()->route('marketing.membership.show', $member->id)
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'member_nric' => 'required|string|max:20|unique:members',
            'member_mrn' => 'nullable|string|max:20|unique:members',
            'member_email' => 'nullable|email|max:255',
            'member_phoneNum' => 'required|string|max:20',
            'member_gender' => 'required|in:Male,Female',
            'member_address' => 'nullable|string',
            'member_dob' => 'required|date',
            'terms' => 'required',
            'is_ecard_given' => 'boolean',
        ]);

        try {
            // Prepare member data with the current authenticated user's ID
            $memberData = $request->except(['terms', 'member_emergencyContactName', 'member_emergencyContactPhone', 'member_medicalConditions']);
            $memberData['registered_by'] = Auth::id();
            
            $member = Member::create($memberData);

            // Send email notification to IT (temporarily disabled for debugging)
            try {
                // Mail::send(new \App\Mail\NewMemberRegistered($member));
                // Email notification temporarily disabled
            } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                return response()->view('errors.server-down');
            } catch (\Exception $e) {
                return response()->view('errors.server-down');
            }

            return redirect()->route('marketing.membership.list')
                ->with('success', 'Member registered successfully.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to create member: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('marketing.membership.registration');
    }

    public function searchPatients(Request $request)
    {
        try {
            $query = $request->input('query');

            $patients = Patient::where('Name', 'like', "%{$query}%")
                ->orWhere('MRN', 'like', "%{$query}%")
                ->orWhere('Nationality_ID', 'like', "%{$query}%")
                ->limit(10)
                ->get(['id', 'Name', 'MRN', 'Nationality_ID']);

            return response()->json($patients);
        } catch (\Exception $e) {
            Log::error('Patient search error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'An error occurred while searching patients',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle the is_flagged status for a member (AJAX)
     */
    public function toggleFlag($id)
    {
        $member = Member::findOrFail($id);
        $member->is_flagged = !$member->is_flagged;
        $member->save();
        return response()->json(['success' => true, 'is_flagged' => $member->is_flagged]);
    }

    /**
     * Toggle the is_ecard_given status for a member (AJAX)
     */
    public function toggleEcard($id)
    {
        $member = Member::findOrFail($id);
        $member->is_ecard_given = !$member->is_ecard_given;
        $member->save();
        return response()->json(['success' => true, 'is_ecard_given' => $member->is_ecard_given]);
    }

    /**
     * Resource index method for admin.members.index
     */
    public function index()
    {
        $query = Member::query();

        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('member_name', 'like', "%{$search}%")
                  ->orWhere('member_nric', 'like', "%{$search}%")
                  ->orWhere('member_mrn', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(10)->withQueryString();
        return view('admin.members.listMembers', compact('members'));
    }

    public function unverifiedList()
    {
        $response = \Illuminate\Support\Facades\Http::get('https://healthform.jmc.my/healthform/public/api/unverifiedsc');
        $members = $response->json();

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
        }
        unset($member);

        return view('marketing.membership.unverified', compact('members'));
    }

    public function pendingList()
    {
        try {
            // Fetch pending members from external API with timeout
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get('https://healthform.jmc.my/healthform/public/api/sc');
            
            if (!$response->successful()) {
                throw new \Exception('Failed to fetch data from the server. Status: ' . $response->status());
            }
            
            $members = $response->json();

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

                // Check if user is already a member locally
                if ($nrid) {
                    $member['is_existing_member'] = \App\Models\Member::where('member_nric', $nrid)->exists();
                } else {
                    $member['is_existing_member'] = false;
                }
            }
            unset($member);

            // Sort latest first by id if available
            usort($members, function($a, $b) {
                return ($b['id'] ?? 0) - ($a['id'] ?? 0);
            });

            // Paginate the results
            $perPage = 10;
            $currentPage = request()->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedMembers = array_slice($members, $offset, $perPage);
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedMembers,
                count($members),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view('marketing.membership.pending', [
                'paginator' => $paginator,
            ]);
            
        } catch (ConnectionException $e) {
            Log::error('Connection error in pendingList: ' . $e->getMessage());
            return response()->view('errors.500', [
                'exception' => new \Exception('Unable to connect to the server. Please check your internet connection and try again.')
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Error in pendingList: ' . $e->getMessage());
            return response()->view('errors.500', [
                'exception' => $e
            ], 500);
        }
    }

    /**
     * Verify a pending member (marketing)
     */
    public function verifyPending($id)
    {
        // Fetch the member's data from the pending list BEFORE verifying
        $response = \Illuminate\Support\Facades\Http::get('https://healthform.jmc.my/healthform/public/api/sc');
        $members = $response->json();
        $memberData = collect($members)->firstWhere('id', (string)$id);

        if ($memberData) {
            // Attempt to map MRN from local patients by Nationality_ID (NRIC)
            $patientMRN = \App\Models\Patient::where('Nationality_ID', $memberData['nrid'] ?? null)->value('MRN');

            // If no MRN, block verification
            if (empty($patientMRN)) {
                return redirect()->route('marketing.membership.pending')
                    ->with('error', 'Member is not registered in HIS');
            }

            // Create local member if not existing
            $exists = \App\Models\Member::where('member_nric', $memberData['nrid'] ?? null)->exists();
            if (!$exists) {
                \App\Models\Member::create([
                    'member_name'      => $memberData['fullname'] ?? null,
                    'member_nric'      => $memberData['nrid'] ?? null,
                    'member_gender'    => $memberData['gender'] ?? null,
                    'member_phoneNum'  => $memberData['phonenumber'] ?? '',
                    'member_dob'       => $memberData['dob'] ?? '',
                    'member_address'   => $memberData['address'] ?? '',
                    'member_email'     => $memberData['email'] ?? '',
                    'member_mrn'       => $patientMRN ?: null,
                    'registered_by'    => Auth::id(),
                ]);
            }
        }

        // Call external API to activate/verify
        \Illuminate\Support\Facades\Http::put("https://healthform.jmc.my/healthform/public/api/sc/{$id}/activate");

        return redirect()->route('marketing.membership.pending')
            ->with('success', 'Member verified and registered!');
    }

    /**
     * Mark a pending member as not verified (marketing)
     */
    public function rejectPending($id)
    {
        // Call external API to set unverified
        \Illuminate\Support\Facades\Http::put("https://healthform.jmc.my/healthform/public/api/sc/{$id}/unverified");

        return redirect()->route('marketing.membership.pending')
            ->with('error', 'Member marked as not verified.');
    }

    /**
     * Update pending members' patient status by rechecking against patients table
     */
    public function updatePendingMembers()
    {
        try {
            // Fetch pending members from external API
            $response = \Illuminate\Support\Facades\Http::get('https://healthform.jmc.my/healthform/public/api/sc');
            $members = $response->json();

            if (!$members) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch pending members from API'
                ], 500);
            }

            // Fetch all patients' Nationality_ID and MRN
            $patients = \App\Models\Patient::pluck('MRN', 'Nationality_ID');
            $updatedCount = 0;
            $updatedMembers = [];

            foreach ($members as &$member) {
                $nrid = $member['nrid'] ?? null;
                $previousStatus = $member['is_patient'] ?? false;
                
                if ($nrid && $patients->has($nrid)) {
                    $member['is_patient'] = true;
                    $member['patient_mrn'] = $patients[$nrid];
                    if (!$previousStatus) {
                        $updatedCount++;
                        $updatedMembers[] = [
                            'id' => $member['id'] ?? null,
                            'name' => $member['fullname'] ?? 'Unknown',
                            'nrid' => $nrid,
                            'mrn' => $patients[$nrid]
                        ];
                    }
                } else {
                    $member['is_patient'] = false;
                    $member['patient_mrn'] = null;
                }

                // Also recheck if user is already a member locally
                if ($nrid) {
                    $member['is_existing_member'] = \App\Models\Member::where('member_nric', $nrid)->exists();
                } else {
                    $member['is_existing_member'] = false;
                }
            }
            unset($member);

            return response()->json([
                'success' => true,
                'message' => "Updated {$updatedCount} member(s) status",
                'updated_count' => $updatedCount,
                'updated_members' => $updatedMembers,
                'all_members' => $members
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating pending members:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating member status: ' . $e->getMessage()
            ], 500);
        }
    }
}
