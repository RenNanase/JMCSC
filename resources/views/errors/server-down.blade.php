<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Server Error</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            font-family: 'Figtree', sans-serif;
        }
        .error-container {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        }
        .error-icon-bg {
            background-color: #fecaca;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .error-icon {
            color: #b91c1c;
        }
        .error-title {
            color: #7f1d1d;
        }
        .error-message {
            color: #b91c1c;
        }
        .refresh-btn {
            background-color: #dc2626;
            color: white;
        }
        .refresh-btn:hover {
            background-color: #b91c1c;
        }
        .back-btn {
            border: 1px solid #fca5a5;
            color: #b91c1c;
            background-color: white;
        }
        .back-btn:hover {
            background-color: #fef2f2;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center error-container py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <!-- Error Icon -->
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full error-icon-bg mb-6">
                    <svg class="h-12 w-12 error-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                    </svg>
                </div>

                <!-- Error Title -->
                <h2 class="text-3xl font-bold error-title mb-4">
                    Server Error
                </h2>

                <!-- Error Message -->
                <p class="text-lg error-message mb-8 leading-relaxed">
                    Sorry! The server is being a bit shy right now. Please refresh to try again.
                </p>

                <!-- Action Buttons -->
                {{-- <div class="space-y-4">
                    <button
                        onclick="window.location.reload();"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium refresh-btn transition duration-150 ease-in-out"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh Page
                    </button>

                    <button
                        onclick="window.history.back();"
                        class="w-full flex justify-center py-3 px-4 rounded-md shadow-sm text-sm font-medium back-btn transition duration-150 ease-in-out"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Go Back
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</body>
</html>
