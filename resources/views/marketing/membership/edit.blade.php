<x-marketing-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#2cacad] leading-tight">
            Edit Member
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-[#27a2a2]">Edit Member: {{ $member->member_name }}</h2>
                <a href="{{ route('marketing.membership.show', $member->id) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 p-4 rounded-md border-l-4 border-red-400">
                    <div class="text-sm text-red-600 font-medium">Please fix the following errors:</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('marketing.membership.update', $member->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-[#27a2a2] mb-4 pb-2 border-b border-[#27a2a2]/10">Personal Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label for="member_name" class="block text-sm font-medium text-[#27a2a2] mb-1">Full Name</label>
                            <input type="text" id="member_name" name="member_name" value="{{ old('member_name', $member->member_name) }}" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                        </div>

                        <!-- IC Number -->
                        <div>
                            <label for="member_nric" class="block text-sm font-medium text-[#27a2a2] mb-1">Nationality ID</label>
                            <input type="text" id="member_nric" name="member_nric" value="{{ old('member_nric', $member->member_nric) }}" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                        </div>

                        <!-- MRN -->
                        <div>
                            <label for="member_mrn" class="block text-sm font-medium text-[#27a2a2] mb-1">MRN</label>
                            <input type="text" id="member_mrn" name="member_mrn" value="{{ old('member_mrn', $member->member_mrn) }}" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]">
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="member_dob" class="block text-sm font-medium text-[#27a2a2] mb-1">Date of Birth</label>
                            <input type="date" id="member_dob" name="member_dob" value="{{ old('member_dob', $member->member_dob->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="member_gender" class="block text-sm font-medium text-[#27a2a2] mb-1">Gender</label>
                            <select id="member_gender" name="member_gender" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                                <option value="Male" {{ (old('member_gender', $member->member_gender) == 'Male') ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ (old('member_gender', $member->member_gender) == 'Female') ? 'selected' : '' }}>Female</option>
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
                            <label for="member_email" class="block text-sm font-medium text-[#27a2a2] mb-1">Email Address</label>
                            <input type="email" id="member_email" name="member_email" value="{{ old('member_email', $member->member_email) }}" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]">
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="member_phoneNum" class="block text-sm font-medium text-[#27a2a2] mb-1">Phone Number</label>
                            <input type="tel" id="member_phoneNum" name="member_phoneNum" value="{{ old('member_phoneNum', $member->member_phoneNum) }}" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]" required>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="member_address" class="block text-sm font-medium text-[#27a2a2] mb-1">Address</label>
                            <textarea id="member_address" name="member_address" rows="3" class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]">{{ old('member_address', $member->member_address) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- E-Card Status Section -->
                <div>
                    <h3 class="text-lg font-medium text-[#27a2a2] mb-4 pb-2 border-b border-[#27a2a2]/10">E-Card Status</h3>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_ecard_given" name="is_ecard_given" value="1" {{ (old('is_ecard_given', $member->is_ecard_given) ? 'checked' : '') }} class="h-4 w-4 text-[#27a2a2] border-[#27a2a2]/20 rounded focus:ring-[#27a2a2]">
                        <label for="is_ecard_given" class="ml-2 text-sm text-gray-600">
                            E-Card has been given to the member
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-[#27a2a2]/10">
                    <a href="{{ route('marketing.membership.show', $member->id) }}" class="px-4 py-2 bg-gray-200 text-[#27a2a2] rounded-md hover:bg-gray-300 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-[#27a2a2] text-white rounded-md hover:bg-[#27a2a2]/80 transition-colors">
                        Update Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-marketing-layout>
