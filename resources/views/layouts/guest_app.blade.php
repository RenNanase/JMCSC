<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-[#2cacad] font-['Poppins'] text-[#102b1f] relative overflow-x-hidden min-h-screen">
        <!-- Cloud Animation Elements - Simplified for this page -->
        <div class="cloud cloud-ltr cloud1"></div>
        <div class="cloud cloud-ltr cloud3"></div>
        <div class="cloud cloud-ltr cloud5"></div>
        <div class="cloud cloud-ltr cloud7"></div>
        <div class="cloud cloud-rtl cloud2"></div>
        <div class="cloud cloud-rtl cloud4"></div>
        <div class="cloud cloud-rtl cloud6"></div>
        <div class="cloud cloud-rtl cloud8"></div>

        <!-- Header -->
        <header class="fixed top-0 w-full z-50 px-4 pt-4">
            <div class="mx-auto max-w-7xl glassmorphism rounded-xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-white">JMC Senior Care</a>
                    </div>

                    <!-- Back button -->
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-white hover:text-white/80">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="pt-20 pb-20 px-4">
            <div class="mx-auto max-w-7xl glassmorphism rounded-xl p-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center text-sm text-[#effcfb] py-4 fixed bottom-0 w-full font-['Montserrat'] backdrop-blur-md bg-[#2cacad]/70 relative z-10">
            &copy; {{ date('Y') }} JMC Senior Care. All rights reserved - <a href="https://github.com/RenNanase" class="text-white hover:text-white/80">RN</a>
        </footer>

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
            
            /* Initial positions */
            .cloud1 { top: 5%; left: 3%; animation-duration: 62s; --scale: 0.5; opacity: 0.7; }
            .cloud2 { top: 15%; right: 18%; animation-duration: 70s; --scale: 0.45; opacity: 0.6; }
            .cloud3 { top: 40%; left: 35%; animation-duration: 58s; --scale: 0.55; opacity: 0.65; }
            .cloud4 { top: 60%; right: 42%; animation-duration: 64s; --scale: 0.4; opacity: 0.7; }
            .cloud5 { top: 75%; left: 62%; animation-duration: 67s; --scale: 0.5; opacity: 0.6; }
            .cloud6 { top: 25%; right: 65%; animation-duration: 72s; --scale: 0.45; opacity: 0.65; }
            .cloud7 { top: 90%; left: 85%; animation-duration: 61s; --scale: 0.4; opacity: 0.7; }
            .cloud8 { top: 50%; right: 2%; animation-duration: 66s; --scale: 0.5; opacity: 0.65; }
            
            /* Keyframe animations */
            @keyframes float-ltr {
                from { transform: translateX(0) scale(var(--scale)); }
                to { transform: translateX(calc(100vw + 300px)) scale(var(--scale)); }
            }
            
            @keyframes float-rtl {
                from { transform: translateX(0) scale(var(--scale)); }
                to { transform: translateX(calc(-100vw - 300px)) scale(var(--scale)); }
            }
            
            /* Glassmorphism styles */
            .glassmorphism {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            }
        </style>
    </body>
</html> 