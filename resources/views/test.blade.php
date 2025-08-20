<!DOCTYPE html>
<html lang="en" class="overflow-hidden h-screen">
<head>
    <meta charset="UTF-8">
    <title>JMC Senior Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#fef2f2] font-['Poppins'] text-gray-800">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50" x-data="{ mobileMenuOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Desktop Navigation Menu - Centered -->
                <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-center">
                    <div class="flex space-x-8">
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" class="flex items-center gap-x-1 px-4 py-2 font-semibold text-[#4d0011] font-['Poppins']" aria-expanded="false" @click="open = !open">
                                Department
                                <svg class="size-5 flex-none text-[#4d0011]" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon" x-bind:class="{ 'rotate-180': open }">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div class="absolute top-full -left-8 z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-[#ffd9d9] shadow-lg ring-1 ring-gray-900/5"
                                x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1">
                                <div class="p-4">
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                        <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-[#fef2f2]">
                                            <svg class="size-6 text-gray-600 group-hover:text-[#4d0011]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-auto">
                                            <a href="{{ route('retail_dept.retail_search') }}" class="block font-semibold text-gray-900">
                                                Retail Department
                                                <span class="absolute inset-0"></span>
                                            </a>
                                            <p class="mt-1 text-gray-600">Search existing patients with their IC number</p>
                                        </div>
                                    </div>
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                        <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-[#fef2f2]">
                                            <svg class="size-6 text-gray-600 group-hover:text-[#4d0011]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                                            </svg>
                                        </div>
                                        <div class="flex-auto">
                                            <a href="{{ route('login') }}?redirect_path=marketing.dashboard" class="block font-semibold text-gray-900">
                                                Marketing Department
                                                <span class="absolute inset-0"></span>
                                            </a>
                                            <p class="mt-1 text-gray-600">Manage the JMCSC</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="h-[calc(100vh-200px)] flex flex-col items-center justify-center text-center px-4 overflow-hidden">
        <div class="flex flex-col items-center justify-center w-full mx-auto">
            <div class="flex items-center justify-center w-full">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-[#4d0011] font-['DM Sans'] text-center">Welcome to JMC Senior Care</h1>
            </div>
            <p class="mt-8 text-xl text-[#102b1f] max-w-3xl text-center font-['Poppins']">Empowering senior care with seamless membership and compassionate service.</p>
        </div>
    </section>
</body>
</html>
