@extends('layouts.guest_app')

@section('content')
<!-- Search Hero Section -->
<div class="mb-10 text-center">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Patient Search</h1>
    <p class="text-gray-700 max-w-2xl mx-auto">Search for existing patients using their IC number, name, or other identifiers to access their records.</p>
</div>

<!-- Main Container -->
<div class="max-w-3xl mx-auto bg-gray-100 rounded-xl shadow-lg border border-gray-200 p-6 mb-10">
    <div x-data="{
        searchType: 'ic',
        searchQuery: '',
        searchResults: [],
        isLoading: false,
        selectedMember: null,
        showResults: false,
        showReceiptModal: false,
        receiptNumber: '',
        purchaseDate: '',
        receiptError: '',

        formatDate(dateString) {
            if (!dateString) return 'Not provided';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-MY', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        },

        search() {
            this.isLoading = true;
            this.showResults = true;

            if (this.searchQuery.length < 3) {
                this.searchResults = [];
                this.isLoading = false;
                return;
            }

            fetch('{{ route('retail_dept.search') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    search_type: this.searchType,
                    query: this.searchQuery
                })
            })
            .then(response => response.json())
            .then(data => {
                this.searchResults = data;
                this.isLoading = false;
            })
            .catch(error => {
                console.error('Error:', error);
                this.isLoading = false;
            });
        },

        showMemberDetails(id) {
            fetch(`{{ url('retail_dept/member') }}/${id}`)
            .then(response => response.json())
            .then(data => {
                this.selectedMember = data;
                this.showResults = false;
            });
        },

        reset() {
            this.selectedMember = null;
            this.searchQuery = '';
            this.searchResults = [];
        },

        submitReceipt() {
            this.receiptError = '';

            if (!this.receiptNumber || !this.purchaseDate) {
                this.receiptError = 'Please fill in all fields';
                return;
            }

            fetch('{{ route('receipts.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    member_id: this.selectedMember.id,
                    receipt_number: this.receiptNumber,
                    purchase_date: this.purchaseDate
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    this.receiptError = Object.values(data.errors)[0][0];
                } else {
                    this.showReceiptModal = false;
                    this.receiptNumber = '';
                    this.purchaseDate = '';
                    alert('Receipt saved successfully!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.receiptError = 'An error occurred while saving the receipt';
            });
        }
    }"
    @click.away="showResults = false">
        <!-- Search Type Tabs -->
        <div class="flex mb-6 bg-gray-200 rounded-lg p-1">
            <button
                @click="searchType = 'ic'; reset()"
                :class="searchType === 'ic' ? 'bg-[#80e0db] text-white' : 'text-gray-700 hover:text-[#80e0db]'"
                class="flex-1 py-2 px-4 rounded-lg transition duration-200 font-medium">
                IC Number
            </button>
            <button
                @click="searchType = 'name'; reset()"
                :class="searchType === 'name' ? 'bg-[#80e0db] text-white' : 'text-gray-700 hover:text-[#80e0db]'"
                class="flex-1 py-2 px-4 rounded-lg transition duration-200 font-medium">
                Name
            </button>
            <button
                @click="searchType = 'mrn'; reset()"
                :class="searchType === 'mrn' ? 'bg-[#80e0db] text-white' : 'text-gray-700 hover:text-[#80e0db]'"
                class="flex-1 py-2 px-4 rounded-lg transition duration-200 font-medium">
                MRN
            </button>
        </div>

        <!-- Member details view -->
        <div x-show="selectedMember" x-cloak class="bg-white rounded-lg p-6 text-gray-900 shadow-md border border-gray-200">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-xl font-semibold">Patient Details</h3>
                <button @click="selectedMember = null" class="text-gray-400 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="font-medium" x-text="selectedMember.member_name"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">MRN</p>
                        <p class="font-medium" x-text="selectedMember.member_mrn || 'Not provided'"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nationality ID</p>
                        <p class="font-medium" x-text="selectedMember.member_nric"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="font-medium" x-text="formatDate(selectedMember.member_dob)"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-medium" x-text="selectedMember.member_gender"></p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="font-medium" x-text="selectedMember.member_phoneNum"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium" x-text="selectedMember.member_email || 'Not provided'"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium" x-text="selectedMember.member_address || 'Not provided'"></p>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500">Medical Conditions</p>
                <p class="font-medium" x-text="selectedMember.member_medicalConditions || 'None recorded'"></p>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500">Emergency Contact</p>
                <p class="font-medium" x-text="selectedMember.member_emergencyContactName + ' (' + selectedMember.member_emergencyContactPhone + ')' "></p>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
                <button @click="showReceiptModal = true" class="px-4 py-2 bg-[#80e0db] hover:bg-[#80e0db]/80 text-white font-medium rounded-lg transition duration-200">
                    Proceed to Services
                </button>
            </div>
        </div>

        <!-- Receipt Modal -->
        <div x-show="showReceiptModal" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Enter Receipt Details</h3>
                    <button @click="showReceiptModal = false" class="text-gray-400 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Receipt Number</label>
                        <input type="text" x-model="receiptNumber" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-[#80e0db] focus:border-[#80e0db]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Date</label>
                        <input type="date" x-model="purchaseDate" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-[#80e0db] focus:border-[#80e0db]">
                    </div>

                    <div x-show="receiptError" class="text-red-600 text-sm bg-red-50 p-2 rounded-lg" x-text="receiptError"></div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button @click="showReceiptModal = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Cancel
                        </button>
                        <button @click="submitReceipt" class="px-4 py-2 bg-[#80e0db] hover:bg-[#80e0db]/80 text-white font-medium rounded-lg transition duration-200">
                            Save Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Forms (only shown when no member is selected) -->
        <div x-show="!selectedMember">
            <div class="relative mb-4">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg x-show="searchType === 'ic'" class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    <svg x-show="searchType === 'name'" class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <svg x-show="searchType === 'mrn'" class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="searchQuery"
                    @input="search"
                    @focus="showResults = true"
                    :placeholder="searchType === 'ic' ? 'Enter IC Number (e.g., 990412-12-0054)' : searchType === 'name' ? 'Enter patient name' : 'Enter MRN'"
                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 bg-white text-gray-900 placeholder-gray-400 rounded-lg focus:ring-2 focus:ring-[#80e0db] focus:border-[#80e0db] shadow-md">

                <!-- Loading indicator -->
                <div x-show="isLoading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="animate-spin h-5 w-5 text-[#80e0db]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <!-- Search Results Dropdown -->
            <div x-show="showResults && searchQuery.length >= 3"
                 x-cloak
                 class="mt-2 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">

                <div x-show="searchResults.length === 0 && !isLoading" class="p-4 text-center text-gray-500">
                    No results found
                </div>

                <ul x-show="searchResults.length > 0">
                    <template x-for="(member, index) in searchResults" :key="member.id">
                        <li @click="showMemberDetails(member.id)"
                            class="p-3 border-b border-gray-100 last:border-0 hover:bg-gray-50 cursor-pointer transition duration-150">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-gray-900 font-medium" x-text="member.member_name"></p>
                                    <p class="text-gray-500 text-sm" x-text="member.member_nric"></p>
                                    <p class="text-gray-500 text-sm" x-text="'MRN: ' + (member.member_mrn || 'Not provided')"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-500 text-sm" x-text="member.member_phoneNum"></p>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
