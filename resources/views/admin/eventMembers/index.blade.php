<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#2cacad] leading-tight">
            Pending Members
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nationality ID</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Existing Patient?</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">MRN</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Existing Member?</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($paginator as $member)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member['fullname'] ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $member['nrid'] ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if(!empty($member['is_patient']))
                                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-200 text-green-800 rounded">Yes</span>
                                            @else
                                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-200 text-red-800 rounded">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            @if(!empty($member['is_patient']))
                                                {{ $member['patient_mrn'] ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if(!empty($member['is_existing_member']))
                                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-200 text-green-800 rounded">Yes</span>
                                            @else
                                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-200 text-red-800 rounded">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <form action="{{ route('admin.eventMembers.verify', $member['id']) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-[#2cacad] text-white text-xs font-medium rounded hover:bg-[#249b9b] transition">Verify</button>
                                            </form>
                                            <span class="inline-block w-2"></span>
                                            <form action="{{ route('admin.eventMembers.reject', $member['id']) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-700 text-white text-xs font-medium rounded hover:bg-red-800 transition">Not Verify</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V7a4 4 0 10-8 0v3m12 4a4 4 0 01-8 0m8 0v1a4 4 0 01-8 0v-1" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No pending members found.</h3>
                                            <p class="mt-1 text-sm text-gray-500">No pending members match your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($paginator->hasPages())
                                <!-- Previous Page -->
                                @if($paginator->onFirstPage())
                                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-[#2cacad] bg-white border border-[#2cacad] rounded-md hover:bg-[#2cacad] hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </a>
                                @endif

                                <!-- Page Numbers -->
                                <div class="flex space-x-1">
                                    @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                                        @if($page == $paginator->currentPage())
                                            <span class="px-3 py-2 bg-[#2cacad] text-white rounded-md font-medium">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="px-3 py-2 text-[#2cacad] bg-white border border-[#2cacad] rounded-md hover:bg-[#2cacad] hover:text-white transition-colors">{{ $page }}</a>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Next Page -->
                                @if($paginator->hasMorePages())
                                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-[#2cacad] bg-white border border-[#2cacad] rounded-md hover:bg-[#2cacad] hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                @endif
                            @endif
                        </div>
                        <a href="{{ route('admin.eventMembers.unverified') }}" class="inline-block px-4 py-2 bg-white border border-[#2cacad] text-[#2cacad] rounded hover:bg-[#2cacad] hover:text-white transition">View Unverified Members</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
