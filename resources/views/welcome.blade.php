<!DOCTYPE html>
<html lang="en" class="overflow-hidden h-screen">
<head>
    <meta charset="UTF-8">
    <title>JMC Senior Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css') {{-- Assuming Tailwind + PineUI via Vite --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes waveBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            overflow: hidden;
            height: 100vh;
            position: fixed;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #102b53, #183c6a, #0f2748, #20476f);
            background-size: 400% 400%;
            animation: waveBG 15s ease infinite;
        }

        /* Noise overlay */
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            opacity: 0.05;
            background-image: url("https://i.pinimg.com/originals/22/68/a0/2268a09d5298d399fe4b30d079418381.jpg");
        }

        /* Vignette effect */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            background: radial-gradient(ellipse at center, rgba(0,0,0,0) 0%, rgba(0,0,0,0.3) 100%);
        }

        /* Ensure all content appears above the overlays */
        header, section, footer {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="font-['Poppins'] text-gray-800">

    <!-- Header -->
    <header class="fixed top-0 w-full z-50" x-data="{ mobileMenuOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                <!-- Logo (empty for now) -->
                <div class="flex flex-1 items-center justify-start lg:hidden">
                    <!-- Empty for now -->
                </div>

                <!-- Desktop Navigation Menu - Centered -->
                <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-center">
                    <div class="flex space-x-8">
                        <!-- Product dropdown -->
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" class="flex items-center gap-x-1 text-sm/6 font-semibold text-[#e9d7c0] font-['Poppins']" aria-expanded="false" @click="open = !open">
                                Product
                                <svg class="size-5 flex-none text-pink-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon" x-bind:class="{ 'rotate-180': open }">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!--
                              'Product' flyout menu, show/hide based on flyout menu state.

                              Entering: "transition ease-out duration-200"
                                From: "opacity-0 translate-y-1"
                                To: "opacity-100 translate-y-0"
                              Leaving: "transition ease-in duration-150"
                                From: "opacity-100 translate-y-0"
                                To: "opacity-0 translate-y-1"
                            -->
                            <div class="absolute top-full -left-8 z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-[#7d9fc0] shadow-lg ring-1 ring-gray-900/5"
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1">
                                <div class="p-4">
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                        <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-[#faf6f2]">
                                            <svg class="size-6 text-gray-600 group-hover:text-[#cebd54]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-auto">
                                            <a href="#" class="block font-semibold text-gray-900">
                                                Announcement
                                                <span class="absolute inset-0"></span>
                                            </a>
                                            <p class="mt-1 text-gray-600">We are currently undergoing maintenance</p>
                                        </div>
                                    </div>
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                        <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-[#faf6f2]">
                                            <svg class="size-6 text-gray-600 group-hover:text-[#cebd54]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                                            </svg>
                                        </div>
                                        <div class="flex-auto">
                                            <a href="#" class="block font-semibold text-gray-900">
                                                Event
                                                <span class="absolute inset-0"></span>
                                            </a>
                                            <p class="mt-1 text-gray-600">We are currently undergoing maintenance</p>
                                        </div>
                                    </div>
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                        <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-[#faf6f2]">
                                            <svg class="size-6 text-gray-600 group-hover:text-[#cebd54]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-auto">
                                            <a href="#" class="block font-semibold text-gray-900">
                                                Membership Plan
                                                <span class="absolute inset-0"></span>
                                            </a>
                                            <p class="mt-1 text-gray-600">We are currently undergoing maintenance</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <a href="#" class="text-sm/6 font-semibold text-[#e9d7c0] font-['Poppins']">TBA</a>
                        <a href="#" class="text-sm/6 font-semibold text-[#e9d7c0] font-['Poppins']">TBA</a>
                        <a href="https://r.search.yahoo.com/_ylt=AwrKBzj7mwBomgIATErjPwx.;_ylu=Y29sbwNzZzMEcG9zAzEEdnRpZAMEc2VjA3Ny/RV=2/RE=1746079996/RO=10/RU=https%3a%2f%2fwww.jmc.my%2f/RK=2/RS=7_mTwSffMn527Blr2azqj5gdBkY-" class="text-sm/6 font-semibold text-[#e9d7c0] font-['Poppins']">Company</a>

                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" class="flex items-center gap-x-1 text-sm/6 font-semibold text-[#e9d7c0] font-['Poppins']" aria-expanded="false"
                                @click="open = !open">
                                Department
                                <svg class="size-5 flex-none text-pink-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                    data-slot="icon" x-bind:class="{ 'rotate-180': open }">
                                    <path fill-rule="evenodd"
                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!--
                                  'Product' flyout menu, show/hide based on flyout menu state.

                                  Entering: "transition ease-out duration-200"
                                    From: "opacity-0 translate-y-1"
                                    To: "opacity-100 translate-y-0"
                                  Leaving: "transition ease-in duration-150"
                                    From: "opacity-100 translate-y-0"
                                    To: "opacity-0 translate-y-1"
                                -->
                            <div class="absolute top-full -left-8 z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-[#7d9fc0] shadow-lg ring-1 ring-gray-900/5"
                                x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1">
                                <div class="p-4">
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                        <div
                                            class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-[#faf6f2]">
                                            <svg class="size-6 text-gray-600 group-hover:text-[#cebd54]" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-auto">
                                            <a href="#" class="block font-semibold text-gray-900">
                                                Retail Department
                                                <span class="absolute inset-0"></span>
                                            </a>
                                            <p class="mt-1 text-gray-600">Search exisiting patients with their IC number</p>
                                        </div>
                                    </div>
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                        <div
                                            class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-[#faf6f2]">
                                            <svg class="size-6 text-gray-600 group-hover:text-[#cebd54]" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                                            </svg>
                                        </div>
                                        <div class="flex-auto">
                                            <a href="#" class="block font-semibold text-gray-900">
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

    {{-- Hero Section with Typing Effect --}}
    <section class="h-[calc(100vh-200px)] flex flex-col items-center justify-center text-center px-4 overflow-hidden">
        <div
            x-data="{
                text: '',
                textArray: ['Welcome to JMC Senior Care','Caring for Our Seniors with Love and Respect','Empowering Senior Living, One Member at a Time'],
                textFont: 'DM Sans',
                textIndex: 0,
                charIndex: 0,
                typeSpeed: 110,
                cursorSpeed: 550,
                pauseEnd: 1500,
                pauseStart: 20,
                direction: 'forward',
            }"
            x-init="$nextTick(() => {
                let typingInterval = setInterval(startTyping, $data.typeSpeed);
                function startTyping() {
                    let current = $data.textArray[$data.textIndex];
                    {{-- If the text is fully typed, start deleting --}}
                    if ($data.charIndex > current.length) {
                        $data.direction = 'backward';
                        clearInterval(typingInterval);
                        setTimeout(() => {
                            typingInterval = setInterval(startTyping, $data.typeSpeed);
                        }, $data.pauseEnd);
                    }
                    $data.text = current.substring(0, $data.charIndex);
                    if ($data.direction == 'forward') {
                        $data.charIndex += 1;
                    } else {
                        if ($data.charIndex == 0) {
                            $data.direction = 'forward';
                            clearInterval(typingInterval);
                            setTimeout(() => {
                                $data.textIndex = ($data.textIndex + 1) % $data.textArray.length;
                                typingInterval = setInterval(startTyping, $data.typeSpeed);
                            }, $data.pauseStart);
                        }
                        $data.charIndex -= 1;
                    }
                }

                        setInterval(function(){
            if($refs.cursor.classList.contains('hidden'))
            {
                $refs.cursor.classList.remove('hidden');
            }
            else
            {
                $refs.cursor.classList.add('hidden');
            }
        }, $data.cursorSpeed);

    })"
            class="flex flex-col items-center justify-center w-full mx-auto"
        >
            <div class="flex items-center justify-center w-full">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-[#fed8a6] font-['Ballet'] text-center" x-text="text"></h1>
                <span x-ref="cursor" class="text-4xl md:text-6xl lg:text-7xl font-bold text-[#fed8a6]">|</span>
            </div>

            <p class="mt-8 text-xl text-[#7d9fc0] max-w-3xl text-center font-['Poppins']">Empowering senior care with seamless membership and compassionate service.</p>
        </div>
    </section>


    {{-- Footer --}}
    <footer class="text-center text-sm text-gray-500 py-4 fixed bottom-0 w-full font-['Poppins']">
        &copy; {{ date('Y') }} JMC Senior Care. All rights reserved. - developed by <a href="https://github.com/RenNanase" class="text-pink-600 hover:text-pink-700">dhzrna @ Ren Nanase</a>
    </footer>

    {{-- @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif --}}

</body>
</html>
