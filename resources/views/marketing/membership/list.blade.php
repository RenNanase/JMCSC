<x-marketing-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#2cacad] leading-tight">
            Member List
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-[#27a2a2]">Registered Members</h2>
                <a href="{{ route('marketing.membership.registration') }}" class="px-4 py-2 bg-[#27a2a2] text-white rounded-md hover:bg-[#27a2a2]/80 transition-colors">
                    Add New Member
                </a>
            </div>

            <!-- Search & Filters (Placeholder for future implementation) -->
            <form method="GET" action="{{ route('marketing.membership.list') }}" class="mb-6 bg-gray-50 p-4 rounded-md">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search members..." class="w-full px-3 py-2 border border-[#27a2a2]/20 rounded-md focus:ring-[#27a2a2] focus:border-[#27a2a2]">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-[#27a2a2] text-white rounded-md hover:bg-[#27a2a2]/80 transition-colors">
                        Search
                    </button>
                </div>
            </form>

            <!-- Members Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#27a2a2]/10">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">E-Card</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">NRIC</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Gender</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">DOB</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#27a2a2]/10">
                        @forelse ($members as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <span>{{ $member->member_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($member->is_ecard_given)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Given</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->member_nric }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->member_phoneNum }}<br>
                                <span class="text-xs">{{ $member->member_email }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->member_gender }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->member_dob->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($member->is_active)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button type="button"
                                        class="ecard-toggle-btn text-xs px-2 py-1 rounded-md transition-colors"
                                        data-id="{{ $member->id }}"
                                        data-ecard-status="{{ $member->is_ecard_given ? '1' : '0' }}"
                                        title="Toggle E-Card status">
                                        @if($member->is_ecard_given)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md">✓ Given</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-md"> Pending</span>
                                        @endif
                                    </button>
                                    <a href="{{ route('marketing.membership.show', $member->id) }}" class="text-[#27a2a2] hover:text-[#27a2a2]/80">View</a>
                                    <a href="{{ route('marketing.membership.edit', $member->id) }}" class="text-[#27a2a2] hover:text-[#27a2a2]/80">Edit</a>
                                    <a href="{{ route('marketing.members.purchases', $member->id) }}" class="text-[#27a2a2] hover:text-[#27a2a2]/80">Purchase History</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No members found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</x-marketing-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // E-Card toggle functionality
    document.querySelectorAll('.ecard-toggle-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const memberId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-ecard-status');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`{{ url('marketing/membership') }}/${memberId}/toggle-ecard`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the button text and status
                    const span = this.querySelector('span');
                    if (data.is_ecard_given) {
                        span.className = 'bg-green-100 text-green-800 px-2 py-1 rounded-md';
                        span.innerHTML = '✓ Given';
                        this.setAttribute('data-ecard-status', '1');
                    } else {
                        span.className = 'bg-red-100 text-red-800 px-2 py-1 rounded-md';
                        span.innerHTML = 'Pending';
                        this.setAttribute('data-ecard-status', '0');
                    }

                    // Update the e-card indicator in the name column
                    const row = this.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(2)');

                    if (data.is_ecard_given) {
                        statusCell.innerHTML = '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Given</span>';
                    } else {
                        statusCell.innerHTML = '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Pending</span>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating e-card status');
            });
        });
    });
});
</script>
