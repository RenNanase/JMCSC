<x-marketing-layout>
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
            <h2 class="text-2xl font-semibold text-[#27a2a2] mb-4">Welcome, {{ $userName }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-[#eefbf9]/50 p-4 rounded-lg border border-[#27a2a2]/10">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#27a2a2]/10 text-[#27a2a2]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-[#27a2a2]">Total Members</h3>
                            <p class="text-2xl font-bold text-[#27a2a2]">{{ $totalMembers }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-[#eefbf9]/50 p-4 rounded-lg border border-[#27a2a2]/10">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#27a2a2]/10 text-[#27a2a2]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-[#27a2a2]">New This Month</h3>
                            <p class="text-2xl font-bold text-[#27a2a2]">{{ $newThisMonth }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-[#eefbf9]/50 p-4 rounded-lg border border-[#27a2a2]/10">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#27a2a2]/10 text-[#27a2a2]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-[#27a2a2]">Active Members</h3>
                            <p class="text-2xl font-bold text-[#27a2a2]">{{ $activeMembers }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <!-- <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-[#27a2a2]">Recent Activity</h2>
                <a href="{{route ('marketing.membership.list') }}" class="text-sm text-[#27a2a2] hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#27a2a2]/10">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Member</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Activity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#27a2a2]/10">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">JD</div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-[#27a2a2]">John Doe</div>
                                        <div class="text-xs text-[#27a2a2]/70">john.doe@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#27a2a2]">Membership Renewal</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#27a2a2]">June 2, 2023</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">JS</div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-[#27a2a2]">Jane Smith</div>
                                        <div class="text-xs text-[#27a2a2]/70">jane.smith@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#27a2a2]">New Registration</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#27a2a2]">June 1, 2023</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">RJ</div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-[#27a2a2]">Robert Johnson</div>
                                        <div class="text-xs text-[#27a2a2]/70">robert.j@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#27a2a2]">Profile Update</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#27a2a2]">May 30, 2023</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->

        <!-- Quick Actions -->
        <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
                <h2 class="text-xl font-semibold text-[#27a2a2] mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{route ('marketing.membership.registration') }}" class="block p-3 bg-[#eefbf9]/30 hover:bg-[#eefbf9]/50 rounded-md transition-colors flex items-center text-[#27a2a2]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Register New Member
                    </a>
                    <a href="#" class="block p-3 bg-[#eefbf9]/30 hover:bg-[#eefbf9]/50 rounded-md transition-colors flex items-center text-[#27a2a2]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Export Member List
                    </a>
                    <a href="#" class="block p-3 bg-[#eefbf9]/30 hover:bg-[#eefbf9]/50 rounded-md transition-colors flex items-center text-[#27a2a2]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Send Notifications
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
                <h2 class="text-xl font-semibold text-[#27a2a2] mb-4">Upcoming Renewals</h2>
                <ul class="space-y-4">
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">AL</div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-[#27a2a2]">Amy Lee</div>
                                <div class="text-xs text-[#27a2a2]/70">Expires in 3 days</div>
                            </div>
                        </div>
                        <button class="px-3 py-1 bg-[#27a2a2] text-white text-xs rounded-full hover:bg-[#27a2a2]/80 transition-colors">Renew</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">MB</div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-[#27a2a2]">Mark Brown</div>
                                <div class="text-xs text-[#27a2a2]/70">Expires in 5 days</div>
                            </div>
                        </div>
                        <button class="px-3 py-1 bg-[#27a2a2] text-white text-xs rounded-full hover:bg-[#27a2a2]/80 transition-colors">Renew</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-[#27a2a2] text-white flex items-center justify-center text-sm font-medium">SJ</div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-[#27a2a2]">Sarah Jones</div>
                                <div class="text-xs text-[#27a2a2]/70">Expires in 7 days</div>
                            </div>
                        </div>
                        <button class="px-3 py-1 bg-[#27a2a2] text-white text-xs rounded-full hover:bg-[#27a2a2]/80 transition-colors">Renew</button>
                    </li>
                </ul>
            </div>
        </div> -->
    </div>
</x-marketing-layout> 