<!DOCTYPE html>
<html lang="en" class="overflow-hidden h-screen">
<head>
    <meta charset="UTF-8">
    <title>JMC Senior Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css') {{-- Assuming Tailwind + PineUI via Vite --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Cloud Animation Styles */
        .cloud {
            position: absolute;
            width: 200px;
            height: 60px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50px;
            opacity: 0.8;
            z-index: 0;
        }

        .cloud:before, .cloud:after {
            content: '';
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
        }

        .cloud:before {
            width: 100px;
            height: 100px;
            top: -50px;
            left: 25px;
        }

        .cloud:after {
            width: 80px;
            height: 80px;
            top: -35px;
            left: 100px;
        }

        /* Smaller cloud variation */
        .cloud-sm {
            width: 150px;
            height: 45px;
        }

        .cloud-sm:before {
            width: 75px;
            height: 75px;
            top: -38px;
            left: 19px;
        }

        .cloud-sm:after {
            width: 60px;
            height: 60px;
            top: -26px;
            left: 75px;
        }

        /* Tiny cloud variation */
        .cloud-xs {
            width: 100px;
            height: 30px;
        }

        .cloud-xs:before {
            width: 50px;
            height: 50px;
            top: -25px;
            left: 13px;
        }

        .cloud-xs:after {
            width: 40px;
            height: 40px;
            top: -18px;
            left: 50px;
        }

        /* Left-to-Right Clouds */
        .cloud-ltr {
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-name: float-ltr;
        }

        /* Right-to-Left Clouds */
        .cloud-rtl {
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-name: float-rtl;
        }

        /* Initial positions distributed across the screen */
        /* Layer 1 - Top area (0-20%) */
        .cloud1 { top: 3%; left: 3%; animation-duration: 62s; --scale: 0.5; opacity: 0.7; }
        .cloud2 { top: 7%; right: 18%; animation-duration: 70s; --scale: 0.45; opacity: 0.6; }
        .cloud3 { top: 12%; left: 35%; animation-duration: 58s; --scale: 0.55; opacity: 0.65; }
        .cloud4 { top: 4%; right: 42%; animation-duration: 64s; --scale: 0.4; opacity: 0.7; }
        .cloud5 { top: 16%; left: 62%; animation-duration: 67s; --scale: 0.5; opacity: 0.6; }
        .cloud6 { top: 10%; right: 65%; animation-duration: 72s; --scale: 0.45; opacity: 0.65; }
        .cloud7 { top: 2%; left: 85%; animation-duration: 61s; --scale: 0.4; opacity: 0.7; }
        .cloud8 { top: 18%; right: 2%; animation-duration: 66s; --scale: 0.5; opacity: 0.65; }

        /* Layer 2 - Upper middle area (20-40%) */
        .cloud9 { top: 21%; left: 15%; animation-duration: 68s; --scale: 0.55; opacity: 0.6; }
        .cloud10 { top: 27%; right: 28%; animation-duration: 59s; --scale: 0.5; opacity: 0.7; }
        .cloud11 { top: 32%; left: 48%; animation-duration: 73s; --scale: 0.45; opacity: 0.65; }
        .cloud12 { top: 24%; right: 52%; animation-duration: 63s; --scale: 0.5; opacity: 0.7; }
        .cloud13 { top: 36%; left: 72%; animation-duration: 69s; --scale: 0.45; opacity: 0.65; }
        .cloud14 { top: 30%; right: 75%; animation-duration: 56s; --scale: 0.5; opacity: 0.7; }
        .cloud15 { top: 22%; left: 95%; animation-duration: 71s; --scale: 0.4; opacity: 0.6; }
        .cloud16 { top: 38%; right: 8%; animation-duration: 60s; --scale: 0.45; opacity: 0.7; }

        /* Layer 3 - Lower middle area (40-60%) */
        .cloud17 { top: 41%; left: 8%; animation-duration: 65s; --scale: 0.5; opacity: 0.65; }
        .cloud18 { top: 47%; right: 22%; animation-duration: 74s; --scale: 0.45; opacity: 0.7; }
        .cloud19 { top: 53%; left: 32%; animation-duration: 58s; --scale: 0.5; opacity: 0.65; }
        .cloud20 { top: 44%; right: 42%; animation-duration: 66s; --scale: 0.45; opacity: 0.7; }
        .cloud21 { top: 55%; left: 58%; animation-duration: 70s; --scale: 0.5; opacity: 0.65; }
        .cloud22 { top: 49%; right: 62%; animation-duration: 61s; --scale: 0.4; opacity: 0.6; }
        .cloud23 { top: 43%; left: 82%; animation-duration: 68s; --scale: 0.5; opacity: 0.65; }
        .cloud24 { top: 58%; right: 85%; animation-duration: 64s; --scale: 0.45; opacity: 0.7; }

        /* Layer 4 - Upper bottom area (60-80%) */
        .cloud25 { top: 62%; left: 12%; animation-duration: 67s; --scale: 0.5; opacity: 0.7; }
        .cloud26 { top: 68%; right: 25%; animation-duration: 59s; --scale: 0.45; opacity: 0.6; }
        .cloud27 { top: 74%; left: 38%; animation-duration: 72s; --scale: 0.5; opacity: 0.65; }
        .cloud28 { top: 64%; right: 48%; animation-duration: 63s; --scale: 0.4; opacity: 0.7; }
        .cloud29 { top: 76%; left: 68%; animation-duration: 69s; --scale: 0.45; opacity: 0.65; }
        .cloud30 { top: 70%; right: 78%; animation-duration: 58s; --scale: 0.5; opacity: 0.7; }
        .cloud31 { top: 66%; left: 92%; animation-duration: 71s; --scale: 0.4; opacity: 0.6; }
        .cloud32 { top: 78%; right: 5%; animation-duration: 65s; --scale: 0.45; opacity: 0.7; }

        /* Layer 5 - Bottom area (80-100%) */
        .cloud33 { top: 81%; left: 7%; animation-duration: 66s; --scale: 0.5; opacity: 0.65; }
        .cloud34 { top: 87%; right: 18%; animation-duration: 60s; --scale: 0.4; opacity: 0.7; }
        .cloud35 { top: 93%; left: 28%; animation-duration: 73s; --scale: 0.45; opacity: 0.65; }
        .cloud36 { top: 84%; right: 34%; animation-duration: 62s; --scale: 0.5; opacity: 0.7; }
        .cloud37 { top: 90%; left: 52%; animation-duration: 68s; --scale: 0.45; opacity: 0.65; }
        .cloud38 { top: 86%; right: 58%; animation-duration: 64s; --scale: 0.4; opacity: 0.6; }
        .cloud39 { top: 92%; left: 75%; animation-duration: 70s; --scale: 0.5; opacity: 0.65; }
        .cloud40 { top: 82%; right: 88%; animation-duration: 67s; --scale: 0.45; opacity: 0.7; }

        /* Small cloud variations */
        .small-cloud1 { top: 6%; left: 22%; animation-duration: 57s; --scale: 0.3; opacity: 0.6; }
        .small-cloud2 { top: 15%; right: 85%; animation-duration: 63s; --scale: 0.35; opacity: 0.7; }
        .small-cloud3 { top: 28%; left: 5%; animation-duration: 69s; --scale: 0.3; opacity: 0.65; }
        .small-cloud4 { top: 34%; right: 15%; animation-duration: 56s; --scale: 0.35; opacity: 0.6; }
        .small-cloud5 { top: 52%; left: 15%; animation-duration: 62s; --scale: 0.3; opacity: 0.7; }
        .small-cloud6 { top: 45%; right: 95%; animation-duration: 66s; --scale: 0.35; opacity: 0.65; }
        .small-cloud7 { top: 60%; left: 45%; animation-duration: 59s; --scale: 0.3; opacity: 0.6; }
        .small-cloud8 { top: 72%; right: 35%; animation-duration: 71s; --scale: 0.35; opacity: 0.7; }
        .small-cloud9 { top: 88%; left: 88%; animation-duration: 58s; --scale: 0.3; opacity: 0.65; }
        .small-cloud10 { top: 80%; right: 72%; animation-duration: 65s; --scale: 0.35; opacity: 0.6; }

        /* Keyframe animations for left-to-right and right-to-left movement */
        @keyframes float-ltr {
            from { transform: translateX(0) scale(var(--scale)); }
            to { transform: translateX(calc(100vw + 300px)) scale(var(--scale)); }
        }

        @keyframes float-rtl {
            from { transform: translateX(0) scale(var(--scale)); }
            to { transform: translateX(calc(-100vw - 300px)) scale(var(--scale)); }
        }

        /* Glassmorphism styles for hamburger menu */
        .glassmorphism {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .menu-item {
            transition: all 0.2s ease;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .menu-item:active {
            transform: scale(0.98);
        }

        .submenu {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-[#2cacad] font-['Poppins'] text-[#102b1f] relative overflow-x-hidden min-h-screen">
    <!-- Cloud Animation Elements - Distributed across the entire width with different directions -->
    <!-- Left-to-Right Clouds -->
    <div class="cloud cloud-ltr cloud1"></div>
    <div class="cloud cloud-ltr cloud3"></div>
    <div class="cloud cloud-ltr cloud5"></div>
    <div class="cloud cloud-ltr cloud7"></div>
    <div class="cloud cloud-ltr cloud9"></div>
    <div class="cloud cloud-ltr cloud11"></div>
    <div class="cloud cloud-ltr cloud13"></div>
    <div class="cloud cloud-ltr cloud15"></div>
    <div class="cloud cloud-ltr cloud17"></div>
    <div class="cloud cloud-ltr cloud19"></div>
    <div class="cloud cloud-ltr cloud21"></div>
    <div class="cloud cloud-ltr cloud23"></div>
    <div class="cloud cloud-ltr cloud25"></div>
    <div class="cloud cloud-ltr cloud27"></div>
    <div class="cloud cloud-ltr cloud29"></div>
    <div class="cloud cloud-ltr cloud31"></div>
    <div class="cloud cloud-ltr cloud33"></div>
    <div class="cloud cloud-ltr cloud35"></div>
    <div class="cloud cloud-ltr cloud37"></div>
    <div class="cloud cloud-ltr cloud39"></div>

    <!-- Right-to-Left Clouds -->
    <div class="cloud cloud-rtl cloud2"></div>
    <div class="cloud cloud-rtl cloud4"></div>
    <div class="cloud cloud-rtl cloud6"></div>
    <div class="cloud cloud-rtl cloud8"></div>
    <div class="cloud cloud-rtl cloud10"></div>
    <div class="cloud cloud-rtl cloud12"></div>
    <div class="cloud cloud-rtl cloud14"></div>
    <div class="cloud cloud-rtl cloud16"></div>
    <div class="cloud cloud-rtl cloud18"></div>
    <div class="cloud cloud-rtl cloud20"></div>
    <div class="cloud cloud-rtl cloud22"></div>
    <div class="cloud cloud-rtl cloud24"></div>
    <div class="cloud cloud-rtl cloud26"></div>
    <div class="cloud cloud-rtl cloud28"></div>
    <div class="cloud cloud-rtl cloud30"></div>
    <div class="cloud cloud-rtl cloud32"></div>
    <div class="cloud cloud-rtl cloud34"></div>
    <div class="cloud cloud-rtl cloud36"></div>
    <div class="cloud cloud-rtl cloud38"></div>
    <div class="cloud cloud-rtl cloud40"></div>

    <!-- Small Cloud Variations for Additional Coverage Without Overlap -->
    <div class="cloud cloud-sm cloud-ltr small-cloud1"></div>
    <div class="cloud cloud-sm cloud-rtl small-cloud2"></div>
    <div class="cloud cloud-sm cloud-ltr small-cloud3"></div>
    <div class="cloud cloud-sm cloud-rtl small-cloud4"></div>
    <div class="cloud cloud-sm cloud-ltr small-cloud5"></div>
    <div class="cloud cloud-sm cloud-rtl small-cloud6"></div>
    <div class="cloud cloud-sm cloud-ltr small-cloud7"></div>
    <div class="cloud cloud-sm cloud-rtl small-cloud8"></div>
    <div class="cloud cloud-sm cloud-ltr small-cloud9"></div>
    <div class="cloud cloud-sm cloud-rtl small-cloud10"></div>

    <!-- Header -->
    <header class="fixed top-0 w-full z-50 px-4 pt-4" x-data="{ mobileMenuOpen: false }">
        <div class="mx-auto max-w-7xl glassmorphism rounded-xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-white">JMC Senior Care</div>
                </div>

                <!-- Hamburger Button (always visible) -->
                <div class="flex items-center">
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-3 rounded-full text-white hover:text-white focus:outline-none relative overflow-hidden"
                        :class="mobileMenuOpen ? 'glassmorphism' : 'hover:glassmorphism'"
                        aria-expanded="false"
                    >
                        <svg
                            class="h-6 w-6 transition-transform duration-300"
                            :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg
                            class="h-6 w-6 transition-transform duration-300"
                            :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state -->
        <div
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-10"
            class="absolute inset-x-0 top-16 z-10 glassmorphism rounded-lg mx-4 mt-2"
        >
            <div class="px-3 pt-3 pb-4 space-y-2 sm:px-4">
                <!-- <a href="#" class="menu-item block px-4 py-3 rounded-md text-base font-medium text-white hover:text-white">Product</a>
                <a href="#" class="menu-item block px-4 py-3 rounded-md text-base font-medium text-white hover:text-white">TBA</a>
                <a href="#" class="menu-item block px-4 py-3 rounded-md text-base font-medium text-white hover:text-white">TBA</a> -->

                <!-- Department submenu -->
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        class="menu-item flex justify-between w-full px-4 py-3 text-base font-medium text-white hover:text-white rounded-md"
                    >
                        <span>Department</span>
                        <svg
                            class="w-5 h-5 ml-2 transform transition-transform duration-200"
                            x-bind:class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="submenu px-2 py-2 rounded-md mt-2 mx-2"
                    >
                        <a href="{{ route('retail_dept.retail_search') }}" class="menu-item block px-4 py-2 text-sm rounded-md text-white hover:text-white">
                            Retail Department
                        </a>
                        <a href="{{ route('login') }}?redirect_to=marketing.dashboard"
                           class="menu-item block px-4 py-2 text-sm rounded-md text-white hover:text-white">
                            Marketing Department
                        </a>
                        <a href="{{ route('login') }}?redirect_to=admin.dashboard"
                           class="menu-item block px-4 py-2 text-sm rounded-md text-white hover:text-white">
                            Admin Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Hero Section with Typing Effect --}}
    <section class="h-[calc(100vh-200px)] flex flex-col items-center justify-center text-center px-4 overflow-hidden relative z-10">
        <div
            x-data="{
                text: '',
                textArray: [
                    'Welcome to JMC Senior Care',
                    'Care is not a feature—it\'s a philosophy',
                    'Designed to serve those who once served us'
                ],
                textIndex: 0,
                charIndex: 0,
                typeSpeed: 110,
                cursorSpeed: 550,
                pauseEnd: 1500,
                pauseStart: 20,
                direction: 'forward'
            }"
            x-init="(() => {
                let typingInterval;

                function startTyping() {
                    let current = textArray[textIndex];

                    if (charIndex > current.length) {
                        direction = 'backward';
                        clearInterval(typingInterval);
                        setTimeout(() => {
                            typingInterval = setInterval(startTyping, typeSpeed);
                        }, pauseEnd);
                    }

                    text = current.substring(0, charIndex);

                    if (direction == 'forward') {
                        charIndex += 1;
                    } else {
                        if (charIndex == 0) {
                            direction = 'forward';
                            clearInterval(typingInterval);
                            setTimeout(() => {
                                textIndex = (textIndex + 1) % textArray.length;
                                typingInterval = setInterval(startTyping, typeSpeed);
                            }, pauseStart);
                        }
                        charIndex -= 1;
                    }
                }

                typingInterval = setInterval(startTyping, typeSpeed);

                setInterval(function() {
                    if ($refs.cursor.classList.contains('hidden')) {
                        $refs.cursor.classList.remove('hidden');
                    } else {
                        $refs.cursor.classList.add('hidden');
                    }
                }, cursorSpeed);
            })()"
            class="flex flex-col items-center justify-center w-full mx-auto"
        >
            <div class="flex items-center justify-center w-full">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-[#f2fbfa] font-['Playfair Display'] text-center" x-text="text"></h1>
                <span x-ref="cursor" class="text-4xl md:text-6xl lg:text-7xl font-bold text-white">|</span>
            </div>

    </section>


    {{-- Footer --}}
    <footer class="text-center text-sm text-[#effcfb] py-4 fixed bottom-0 w-full font-['Montserrat'] backdrop-blur-md bg-[#2cacad]/70 relative z-10">
        &copy; {{ date('Y') }} JMC Senior Care. All rights reserved. - <a href="https://github.com/RenNanase" class="text-white hover:text-white/80">RN</a>
    </footer>

    {{-- @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif --}}

</body>
</html>




