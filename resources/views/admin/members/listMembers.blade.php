<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#27a2a2] leading-tight">
            {{ __('Registered Members') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.members.index') }}" class="mb-6">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search members..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#27a2a2] focus:ring focus:ring-[#27a2a2] focus:ring-opacity-50">
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#27a2a2] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f7a7a] focus:bg-[#1f7a7a] active:bg-[#1f7a7a] focus:outline-none focus:ring-2 focus:ring-[#27a2a2] focus:ring-offset-2 transition ease-in-out duration-150">
                                Search
                            </button>
                        </div>
                    </form>

                    @if($members->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">E-Card</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">NRIC</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">MRN</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($members as $member)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <div class="flex items-center space-x-2">
                                                    @if($member->is_ecard_given)
                                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-medium" title="E-Card Given">
                                                            ✓
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-orange-100 text-orange-600 rounded-full text-xs font-medium" title="E-Card Pending">
                                                            ✗
                                                        </span>
                                                    @endif
                                                    <span>{{ $member->member_name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                @if($member->is_ecard_given)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Given</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $member->member_nric }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $member->member_mrn }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <button type="button"
                                                        class="flag-btn group"
                                                        data-id="{{ $member->id }}"
                                                        title="Mark as updated in HIS"
                                                        aria-label="Flag member"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                             fill="{{ $member->is_flagged ? '#ec4899' : 'none' }}"
                                                             viewBox="0 0 24 24" stroke="{{ $member->is_flagged ? '#ec4899' : '#a0aec0' }}" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5v16m0 0c0-2.5 2-4.5 4.5-4.5S14 18.5 16.5 18.5 21 16.5 21 14V5H5z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="ecard-btn group"
                                                        data-id="{{ $member->id }}"
                                                        title="Toggle E-Card status"
                                                        aria-label="Toggle E-Card"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                             fill="{{ $member->is_ecard_given ? '#3b82f6' : 'none' }}"
                                                             viewBox="0 0 24 24" stroke="{{ $member->is_ecard_given ? '#3b82f6' : '#a0aec0' }}" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $members->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V7a4 4 0 10-8 0v3m12 4a4 4 0 01-8 0m8 0v1a4 4 0 01-8 0v-1" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No members found</h3>
                            <p class="mt-1 text-sm text-gray-500">No members match your search criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.flag-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const memberId = this.getAttribute('data-id');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`{{ url('admin/members') }}/${memberId}/toggle-flag`, {
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
                    // Toggle the flag color
                    const svg = this.querySelector('svg');
                    if (data.is_flagged) {
                        svg.setAttribute('fill', '#ec4899');
                        svg.setAttribute('stroke', '#ec4899');
                    } else {
                        svg.setAttribute('fill', 'none');
                        svg.setAttribute('stroke', '#a0aec0');
                    }
                }
            });
        });
    });

    // E-Card toggle functionality
    document.querySelectorAll('.ecard-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const memberId = this.getAttribute('data-id');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`{{ url('admin/members') }}/${memberId}/toggle-ecard`, {
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
                    // Toggle the e-card color
                    const svg = this.querySelector('svg');
                    if (data.is_ecard_given) {
                        svg.setAttribute('fill', '#3b82f6');
                        svg.setAttribute('stroke', '#3b82f6');
                    } else {
                        svg.setAttribute('fill', 'none');
                        svg.setAttribute('stroke', '#a0aec0');
                    }

                    // Update the e-card indicator in the name column
                    const row = this.closest('tr');
                    const nameCell = row.querySelector('td:first-child');
                    const indicator = nameCell.querySelector('.inline-flex');
                    const statusCell = row.querySelector('td:nth-child(2)');

                    if (data.is_ecard_given) {
                        indicator.className = 'inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-medium';
                        indicator.innerHTML = '✓';
                        indicator.title = 'E-Card Given';
                        statusCell.innerHTML = '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Given</span>';
                    } else {
                        indicator.className = 'inline-flex items-center justify-center w-6 h-6 bg-orange-100 text-orange-600 rounded-full text-xs font-medium';
                        indicator.innerHTML = '✗';
                        indicator.title = 'E-Card Pending';
                        statusCell.innerHTML = '<span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Pending</span>';
                    }
                }
            });
        });
    });
});
</script>
