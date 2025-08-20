<x-marketing-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#2cacad] leading-tight">
            Member Details
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-md border border-[#27a2a2]/10 overflow-hidden">
            <!-- Header -->
            <div class="bg-[#27a2a2]/5 p-4 border-b border-[#27a2a2]/10">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">

                        <div>
                            <h2 class="text-xl font-semibold text-[#27a2a2]">{{ $member->member_name }}</h2>
                            <p class="text-sm text-[#27a2a2]/70">
                                Member since {{ $member->created_at->format('d M Y') }}
                                •
                                @if($member->is_active)
                                    <span class="text-green-600 font-medium">Active</span>
                                @else
                                    <span class="text-red-600 font-medium">Inactive</span>
                                @endif
                                •
                                @if($member->is_ecard_given)
                                    <span class="text-blue-600 font-medium">✓ E-Card Given</span>
                                @else
                                    <span class="text-orange-600 font-medium">✗ E-Card Pending</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('marketing.membership.edit', $member->id) }}" class="px-3 py-1.5 bg-[#27a2a2] text-white text-sm rounded-md hover:bg-[#27a2a2]/80 transition-colors">
                            Edit
                        </a>
                        <a href="{{ route('marketing.membership.list') }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 transition-colors">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Member Details -->
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Personal Information -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-md font-medium text-[#27a2a2] mb-3">Personal Information</h3>
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div class="text-gray-500">NRIC</div>
                                <div>{{ $member->member_nric }}</div>
                                <div class="text-gray-500">MRN</div>
                                <div>{{ $member->member_mrn ?? 'Not assigned' }}</div>
                                <div class="text-gray-500">Date of Birth</div>
                                <div>{{ $member->member_dob->format('d/m/Y') }}</div>
                                <div class="text-gray-500">Gender</div>
                                <div>{{ $member->member_gender }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Contact Information -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-md font-medium text-[#27a2a2] mb-3">Contact Information</h3>
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div class="text-gray-500">Phone</div>
                                <div>{{ $member->member_phoneNum }}</div>
                                <div class="text-gray-500">Email</div>
                                <div>{{ $member->member_email ?? 'Not provided' }}</div>
                                <div class="text-gray-500">Address</div>
                                <div>{{ $member->member_address ?? 'Not provided' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Future sections can be added here -->
            </div>
        </div>
    </div>
</x-marketing-layout>
