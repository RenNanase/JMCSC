<x-admin-layout>
    <div class="p-6 space-y-6">
        <!-- Welcome Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-[#27a2a2]/10">
            <h2 class="text-2xl font-semibold text-[#27a2a2] mb-6">Welcome, {{ auth()->user()->name }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Users Card -->
                <div class="bg-[#eefbf9]/50 p-6 rounded-lg border border-[#27a2a2]/10">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#27a2a2]/10 text-[#27a2a2]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-[#27a2a2]">Total Users</h3>
                            <p class="text-2xl font-bold text-[#27a2a2]">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Patients Card -->
                <div class="bg-[#eefbf9]/50 p-6 rounded-lg border border-[#27a2a2]/10">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#27a2a2]/10 text-[#27a2a2]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-[#27a2a2]">Total Patients</h3>
                            <p class="text-2xl font-bold text-[#27a2a2]">{{ $totalPatients }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Members Card -->
                <div class="bg-[#eefbf9]/50 p-6 rounded-lg border border-[#27a2a2]/10">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#27a2a2]/10 text-[#27a2a2]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-[#27a2a2]">Total Members</h3>
                            <p class="text-2xl font-bold text-[#27a2a2]">{{ $totalMembers }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Users -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-[#27a2a2]/10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-[#27a2a2]">Recent Users</h2>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-[#27a2a2] hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#27a2a2]/10">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[#27a2a2]/10">
                            @foreach($recentUsers as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-[#27a2a2]">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[#27a2a2]">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[#27a2a2]">{{ $user->created_at->diffForHumans() }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Members -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-[#27a2a2]/10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-[#27a2a2]">Recent Members</h2>
                    <a href="{{ route('admin.members.index') }}" class="text-sm text-[#27a2a2] hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#27a2a2]/10">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Member</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">NRIC</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Phone</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[#27a2a2]/10">
                            @foreach($recentMembers as $member)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">
                                                {{ substr($member->member_name, 0, 2) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-[#27a2a2]">{{ $member->member_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[#27a2a2]">{{ $member->member_nric }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[#27a2a2]">{{ $member->member_phoneNum }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[#27a2a2]">{{ $member->created_at->diffForHumans() }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
