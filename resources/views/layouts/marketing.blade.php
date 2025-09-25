<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Marketing Department</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>



<body class="font-sans antialiased">

    <div class="min-h-screen bg-[#eefbf9] flex" x-data="{ sidebarCollapsed: false }">
        <!-- Sidebar Navigation -->
        <aside class="transition-all duration-300 ease-in-out shadow-lg z-10" :class="sidebarCollapsed ? 'w-20' : 'w-64'"
               x-data="{ open: true, membershipOpen: false }">
            <div class="h-full bg-[#2cacad]/10 border-r border-[#2cacad]/20 flex flex-col">
                <!-- Logo and Brand -->
                <div class="px-6 py-5 border-b border-[#2cacad]/20 flex items-center justify-between">
                    <a href="{{ route('marketing.dashboard') }}" class="text-xl font-bold text-[#2cacad]" x-show="!sidebarCollapsed">
                        JMCSC
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
                        <a href="{{ route('marketing.dashboard') }}" class="group flex items-center px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('marketing.dashboard') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span x-show="!sidebarCollapsed">Dashboard</span>
                        </a>

                        <!-- Membership Management Dropdown -->
                        <div class="space-y-1">
                            <button @click="membershipOpen = !membershipOpen" class="w-full flex items-center justify-between px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('marketing.membership.*') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span x-show="!sidebarCollapsed">Membership</span>
                                </div>
                                <svg x-show="!sidebarCollapsed" class="w-5 h-5 transform transition-transform duration-200" :class="{'rotate-180': membershipOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Membership Sub Items -->
                            <div x-show="membershipOpen && !sidebarCollapsed" x-transition class="pl-12 space-y-1">
                                <a href="{{ route('marketing.membership.registration') }}" class="block py-2 px-3 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('marketing.membership.registration') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                                    Registration
                                </a>
                                <a href="{{ route('marketing.membership.list') }}" class="block py-2 px-3 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('marketing.membership.list') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                                    Member List
                                </a>
                                {{-- <a href="{{ route('marketing.membership.unverified') }}" class="block py-2 px-3 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('marketing.membership.unverified') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                                    Unverified Members
                                </a> --}}
                                <a href="{{ route('marketing.membership.pending') }}" class="block py-2 px-3 text-sm text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('marketing.membership.pending') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                                    Pending Members
                                </a>
                            </div>
                        </div>

                        <!-- Reports Link -->
                        <!-- <a href="{{ route('marketing.dashboard') }}" class="group flex items-center px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('reports') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span x-show="!sidebarCollapsed">Reports</span>
                        </a> -->

                        <!-- Analytics Link -->
                        <!-- <a href="{{ route('marketing.dashboard') }}" class="group flex items-center px-3 py-2.5 text-[#2cacad] hover:bg-[#2cacad]/10 rounded-md transition {{ request()->routeIs('analytics') ? 'bg-[#2cacad]/10 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span x-show="!sidebarCollapsed">Analytics</span>
                        </a> -->
                    </div>
                </div>

                <!-- User Profile Section -->
                <div class="mt-auto px-3 py-4 border-t border-[#2cacad]/20">
                    <div x-show="!sidebarCollapsed" class="flex items-center px-3 py-2">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-[#2cacad] text-white flex items-center justify-center text-sm font-medium">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <div class="text-sm font-medium text-[#2cacad] truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-[#2cacad]/70 truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div x-show="sidebarCollapsed" class="flex justify-center py-2">
                        <div class="h-8 w-8 rounded-full bg-[#2cacad] text-white flex items-center justify-center text-sm font-medium">
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
                    <h2 class="font-semibold text-center text-xl text-[#2cacad] leading-tight">
                        @isset($header)
                            {{ $header }}
                        @else
                            Marketing Department
                        @endisset
                    </h2>

                    <!-- Notifications & Quick Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- <button class="text-[#2cacad] hover:text-[#1e8e8f] transition-colors p-1 rounded-full hover:bg-[#2cacad]/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button> -->
                        <a href="{{ route('welcome') }}" class="text-[#2cacad] hover:text-[#1e8e8f] transition-colors p-1 rounded-full hover:bg-[#2cacad]/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#eefbf9] p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class=" py-4 px-6 text-center text-sm text-[#effcfb/80 border-t border-[#effcfb]/10">
                &copy; {{ date('Y') }} JMC Senior Care. All rights reserved -<a href="https://github.com/RenNanase" class="text-[#24777a] hover:text-[#44ccc7]">RN</a>
            </footer>
        </div>
    </div>
</body>
</html>

