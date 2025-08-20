<x-marketing-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#2cacad] leading-tight">
            Member Registration
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
            <h2 class="text-2xl font-semibold text-[#27a2a2] mb-6">Register New Member</h2>

            <form action="{{ route('marketing.membership.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Personal Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-[#27a2a2] mb-4 pb-2 border-b border-[#27a2a2]/10">Patient Information</h3>

                    <div class="mb-6">
                        <label for="patient_search" class="block text-sm font-medium text-[#27a2a2] mb-1">Search Patient</label>
                        <div class="relative">
                            <input type="text" id="patient_search" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" placeholder="Search by name, MRN, or Nationality ID...">
                            <div id="search_results" class="absolute z-10 w-full mt-1 bg-white border border-[#27a2a2]/20 rounded-md shadow-lg hidden"></div>
                        </div>
                    </div>

                    <div id="selected_patient" class="hidden p-4 bg-[#27a2a2]/5 rounded-md mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[#27a2a2] mb-1">Patient Name</label>
                                <input type="text" id="patient_name" name="patient_name" class="w-full px-3 py-2 bg-white border border-[#27a2a2]/20 rounded-md" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#27a2a2] mb-1">MRN</label>
                                <input type="text" id="patient_mrn" name="patient_mrn" class="w-full px-3 py-2 bg-white border border-[#27a2a2]/20 rounded-md" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#27a2a2] mb-1">Nationality ID</label>
                                <input type="text" id="patient_nationality_id" name="patient_nationality_id" class="w-full px-3 py-2 bg-white border border-[#27a2a2]/20 rounded-md" readonly>
                            </div>
                        </div>
                        <input type="hidden" id="patient_id" name="patient_id">
                        <input type="hidden" id="member_mrn_hidden" name="member_mrn">
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-[#27a2a2] mb-4 pb-2 border-b border-[#27a2a2]/10">Personal Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label for="member_name" class="block text-sm font-medium text-[#27a2a2] mb-1">Full Name</label>
                            <input type="text" id="member_name" name="member_name" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                        </div>

                        <!-- IC Number -->
                        <div>
                            <label for="member_nric" class="block text-sm font-medium text-[#27a2a2] mb-1">Nationality ID</label>
                            <input type="text" id="member_nric" name="member_nric" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required placeholder="e.g., 990412-12-0054">
                        </div>

                        <!-- MRN -->
                        <div>
                            <label for="member_mrn" class="block text-sm font-medium text-[#27a2a2] mb-1">MRN</label>
                            <input type="text" id="member_mrn" name="member_mrn" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" placeholder="Medical Record Number">
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="member_dob" class="block text-sm font-medium text-[#27a2a2] mb-1">Date of Birth</label>
                            <input type="date" id="member_dob" name="member_dob" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="member_gender" class="block text-sm font-medium text-[#27a2a2] mb-1">Gender</label>
                            <select id="member_gender" name="member_gender" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-[#27a2a2] mb-4 pb-2 border-b border-[#27a2a2]/10">Contact Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label for="member_email" class="block text-sm font-medium text-[#27a2a2] mb-1">Email Address (Optional)</label>
                            <input type="email" id="member_email" name="member_email" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" placeholder="Enter email address">
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="member_phoneNum" class="block text-sm font-medium text-[#27a2a2] mb-1">Phone Number</label>
                            <input type="tel" id="member_phoneNum" name="member_phoneNum" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="member_address" class="block text-sm font-medium text-[#27a2a2] mb-1">Address</label>
                            <textarea id="member_address" name="member_address" rows="3" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col space-y-4">
                    <!-- E-Card Checkbox -->
                    <div class="flex items-center">
                        <input type="checkbox" id="is_ecard_given" name="is_ecard_given" class="h-4 w-4 text-[#27a2a2] border-[#27a2a2]/20 rounded focus:ring-[#27a2a2]">
                        <label for="is_ecard_given" class="ml-2 text-sm text-gray-600">
                            E-Card has been given to the member
                        </label>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-[#27a2a2] border-[#27a2a2]/20 rounded focus:ring-[#27a2a2]" required>
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the terms and conditions of membership
                        </label>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-[#27a2a2]/10">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-[#27a2a2] rounded-md hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#27a2a2] text-white rounded-md hover:bg-[#27a2a2]/80 transition-colors">
                            Register Member
                        </button>
                    </div>
                </div>

                </form>
        </div>
    </div>
</x-marketing-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patient_search');
    const resultsDiv = document.getElementById('search_results');
    const selectedPatientDiv = document.getElementById('selected_patient');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();

        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Clear previous results
        resultsDiv.innerHTML = '';

        if (query.length < 2) {
            selectedPatientDiv.classList.add('hidden');
            return;
        }

        // Show loading state
        resultsDiv.innerHTML = '<div class="p-2 text-gray-500">Searching...</div>';
        resultsDiv.classList.remove('hidden');

        // Set new timeout
        searchTimeout = setTimeout(() => {
            fetch(`${window.location.origin}/JMCSC/public/marketing/membership/search-patients?query=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    resultsDiv.innerHTML = '';
                    if (data.length === 0) {
                        resultsDiv.innerHTML = '<div class="p-2 text-gray-500">No patients found</div>';
                        return;
                    }

                    data.forEach(patient => {
                        const div = document.createElement('div');
                        div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                        div.innerHTML = `
                            <div class="font-medium">${patient.Name}</div>
                            <div class="text-sm text-gray-500">
                                MRN: ${patient.MRN} | Nationality ID: ${patient.Nationality_ID || 'Not available'}
                            </div>
                        `;
                        div.onclick = () => {
                            // Hide search results
                            resultsDiv.classList.add('hidden');

                            // Show selected patient section
                            selectedPatientDiv.classList.remove('hidden');

                            // Fill in the patient information (summary)
                            document.getElementById('patient_name').value = patient.Name;
                            document.getElementById('patient_mrn').value = patient.MRN;
                            document.getElementById('patient_nationality_id').value = patient.Nationality_ID;
                            document.getElementById('patient_id').value = patient.id;
                            document.getElementById('member_mrn_hidden').value = patient.MRN;

                            // Autofill registration fields
                            document.getElementById('member_name').value = patient.Name || '';
                            document.getElementById('member_nric').value = patient.Nationality_ID || '';
                            document.getElementById('member_mrn').value = patient.MRN || '';

                            // Auto-fill DOB from NRIC when autofilled
                            (function() {
                                const nric = patient.Nationality_ID || '';
                                const dobInput = document.getElementById('member_dob');
                                const value = nric.replace(/[^0-9]/g, '');
                                if (value.length >= 6) {
                                    const year = value.substring(0, 2);
                                    const month = value.substring(2, 4);
                                    const day = value.substring(4, 6);
                                    let fullYear = parseInt(year, 10);
                                    if (fullYear <= 30) {
                                        fullYear += 2000;
                                    } else {
                                        fullYear += 1900;
                                    }
                                    const dateStr = `${fullYear}-${month}-${day}`;
                                    const dateObj = new Date(dateStr);
                                    if (
                                        dateObj instanceof Date &&
                                        !isNaN(dateObj) &&
                                        dateObj.getFullYear() === fullYear &&
                                        (dateObj.getMonth() + 1) === parseInt(month, 10) &&
                                        dateObj.getDate() === parseInt(day, 10)
                                    ) {
                                        dobInput.value = dateStr;
                                    } else {
                                        dobInput.value = '';
                                    }
                                } else {
                                    dobInput.value = '';
                                }
                            })();

                            // Clear search input
                            searchInput.value = '';
                        };
                        resultsDiv.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultsDiv.innerHTML = '<div class="p-2 text-red-500">Error searching patients</div>';
                });
        }, 300);
    });

    // Close results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.classList.add('hidden');
        }
    });

    // Auto-fill DOB from NRIC
    const nricInput = document.getElementById('member_nric');
    const dobInput = document.getElementById('member_dob');

    // Calculate DOB when typing in NRIC field
    nricInput.addEventListener('input', function() {
        calculateDOB(this.value);
    });

    // Also calculate DOB when leaving the NRIC field
    nricInput.addEventListener('blur', function() {
        calculateDOB(this.value);
    });
});

function calculateDOB(icNumber) {
    // Remove any non-numeric characters
    icNumber = icNumber.replace(/[^0-9]/g, '');

    if (icNumber.length >= 6) {
        // Extract date components
        const year = icNumber.substring(0, 2);
        const month = icNumber.substring(2, 4);
        const day = icNumber.substring(4, 6);

        // Determine full year (assuming 00-30 is 2000-2030, 31-99 is 1931-1999)
        let fullYear = parseInt(year, 10);
        if (fullYear <= 30) {
            fullYear += 2000;
        } else {
            fullYear += 1900;
        }

        // Format date as YYYY-MM-DD for the input field
        const dob = `${fullYear}-${month}-${day}`;

        // Set the date of birth field
        document.getElementById('member_dob').value = dob;
    }
}
</script>
