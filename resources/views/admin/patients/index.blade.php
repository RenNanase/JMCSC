<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#27a2a2] leading-tight">
            {{ __('Patient Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alerts Section -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Action Buttons Section -->
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Import Form -->
                            <form action="{{ route('admin.patients.import') }}" method="POST" enctype="multipart/form-data" class="mb-0" id="importForm">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                            class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-[#27a2a2] file:text-white
                                            hover:file:bg-[#1f7a7a]">
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#27a2a2] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f7a7a] focus:bg-[#1f7a7a] active:bg-[#1f7a7a] focus:outline-none focus:ring-2 focus:ring-[#27a2a2] focus:ring-offset-2 transition ease-in-out duration-150" id="importButton">
                                        <span class="normal-text">Import Excel</span>
                                        <span class="loading-text hidden">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Importing...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a href="{{ route('admin.patients.create') }}" class="inline-flex items-center px-4 py-2 bg-[#27a2a2] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f7a7a] focus:bg-[#1f7a7a] active:bg-[#1f7a7a] focus:outline-none focus:ring-2 focus:ring-[#27a2a2] focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Patient
                        </a>
                    </div>

                    <!-- Search Section -->
                    <div class="mb-6">
                        <form action="{{ route('admin.patients.index') }}" method="GET" class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by name, MRN, or ID number..."
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#27a2a2] focus:ring focus:ring-[#27a2a2] focus:ring-opacity-50">
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#27a2a2] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f7a7a] focus:bg-[#1f7a7a] active:bg-[#1f7a7a] focus:outline-none focus:ring-2 focus:ring-[#27a2a2] focus:ring-offset-2 transition ease-in-out duration-150">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Results Section -->
                    @if($patients && $patients->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">MRN</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nationality ID</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($patients as $patient)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="text-sm font-medium text-gray-900">{{ $patient->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $patient->mrn }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $patient->Nationality_ID }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <x-pagination :paginator="$patients" />
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No patients found</h3>
                            <p class="mt-1 text-sm text-gray-500">No patients match your search criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('importForm').addEventListener('submit', function() {
            const button = document.getElementById('importButton');
            const normalText = button.querySelector('.normal-text');
            const loadingText = button.querySelector('.loading-text');

            normalText.classList.add('hidden');
            loadingText.classList.remove('hidden');
            button.disabled = true;
        });
    </script>
</x-admin-layout>
