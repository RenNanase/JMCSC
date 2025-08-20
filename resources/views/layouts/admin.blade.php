<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JMC Senior Care') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Poppins'] antialiased">
    <div class="min-h-screen bg-[#eefbf9] flex" x-data="{ sidebarCollapsed: false }">
        <!-- Sidebar Navigation -->
        <aside class="transition-all duration-300 ease-in-out shadow-lg z-10" :class="sidebarCollapsed ? 'w-20' : 'w-64'"
               x-data="{ open: true, userManagementOpen: false, patientManagementOpen: false }">
            <div class="h-full bg-[#2cacad]/10 border-r border-[#2cacad]/20 flex flex-col">
                <!-- Logo and Brand -->
                <div class="px-6 py-5 border-b border-[#2cacad]/20 flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl text-[#2cacad]" x-show="!sidebarCollapsed">
                        JMCSC Admin
                    </a>

                    <!-- Collapse Toggle Button -->
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="text-[#2cacad] hover:text-[#1e8e8f] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                            <path x-show="sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="py-4 px-3 flex-1 overflow-y-auto">
                    <div class="space-y-2">
                        <!-- Dashboard Link -->
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#2cacad]/10' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span x-show="!sidebarCollapsed">Dashboard</span>
                        </a>

                        <!-- User Management Dropdown -->
                        <div class="space-y-1">
                            <button @click="userManagementOpen = !userManagementOpen" class="w-full flex items-center justify-between px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('admin.users.*') ? 'bg-[#2cacad]/10' : '' }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span x-show="!sidebarCollapsed">User Management</span>
                                </div>
                                <svg x-show="!sidebarCollapsed" class="w-5 h-5 transform transition-transform duration-200" :class="{'rotate-180': userManagementOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- User Management Sub Items -->
                            <div x-show="userManagementOpen && !sidebarCollapsed" x-transition class="pl-12 space-y-1">
                                <a href="{{ route('admin.users.index') }}" class="block py-2 px-3 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('admin.users.index') ? 'bg-[#2cacad]/10' : '' }}">
                                    User List
                                </a>
                                <a href="{{ route('admin.users.create') }}" class="block py-2 px-3 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('admin.users.create') ? 'bg-[#2cacad]/10' : '' }}">
                                    Add User
                                </a>
                            </div>
                        </div>

                        <!-- Patient Management Dropdown -->
                        <div class="space-y-1">
                            <a href="{{ route('admin.patients.index') }}" class="group flex items-center px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('admin.patients.*') ? 'bg-[#2cacad]/10' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span x-show="!sidebarCollapsed">Patient Management</span>
                            </a>
                        </div>
                        <!-- Member -->
                        <a href="{{ route('admin.members.index') }}" class="group flex items-center px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('admin.members.*') ? 'bg-[#2cacad]/10' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span x-show="!sidebarCollapsed">Member Management</span>
                        </a>
                        <!-- Member Management Link -->
                        <a href="{{ route('admin.eventMembers.index') }}" class="group flex items-center px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('admin.members.*') ? 'bg-[#2cacad]/10' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V7a4 4 0 10-8 0v3m12 4a4 4 0 01-8 0m8 0v1a4 4 0 01-8 0v-1" />
                            </svg>
                            <span x-show="!sidebarCollapsed">New Member - Event</span>
                        </a>
                    </div>
                </div>

                <!-- User Profile Section -->
                <div class="mt-auto px-3 py-4 border-t border-[#2cacad]/20">
                    <div x-show="!sidebarCollapsed" class="flex items-center px-3 py-2">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-[#2cacad] text-white flex items-center justify-center text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <div class="text-sm text-[#2cacad] truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-[#2cacad]/70 truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div x-show="sidebarCollapsed" class="flex justify-center py-2">
                        <div class="h-8 w-8 rounded-full bg-[#2cacad] text-white flex items-center justify-center text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div x-show="!sidebarCollapsed" class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Settings</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full group flex items-center px-3 py-2 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <h2 class="text-xl text-[#2cacad] leading-tight">
                        @isset($header)
                            {{ $header }}
                        @else
                            Admin Dashboard
                        @endisset
                    </h2>

                    <!-- Notifications & Quick Actions -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('welcome') }}" class="text-[#2cacad] hover:text-[#1e8e8f] transition-colors p-1 rounded-full hover:bg-[#2cacad]/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#eefbf9]">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
