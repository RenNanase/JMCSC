<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error | JMC Senior Care</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #2cacad;
            color: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1rem;
        }
        .error-container {
            max-width: 600px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .error-code {
            font-size: 6rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .error-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #ffffff;
        }
        .error-message {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
        }
        .error-details {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 0.5rem;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .error-actions a {
            min-width: 200px;
        }

        @media (max-width: 768px) {
            .error-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .error-actions a {
                width: 100%;
            }
        }
    </style>
</head>
<body class="h-full">
    <div id="error-container" class="error-gradient">
        <!-- Error Header -->
        <div class="error-header">
            <div style="font-size: 0;">
                <svg width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h1 style="font-size: 3.5rem; font-weight: 800; margin: 0.5rem 0;">500</h1>
            <p style="font-size: 1.25rem; opacity: 0.9; margin: 0;">Internal Server Error</p>
        </div>
        
        <!-- Error Content -->
        <div class="error-content">
            <div style="max-width: 800px; width: 100%;">
                <h2 style="font-size: 2rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                    Oops! Something went wrong
                </h2>
                <p style="font-size: 1.125rem; color: #4b5563; margin-bottom: 2rem; line-height: 1.6;">
                    We're sorry, but we've encountered an unexpected error. Our team has been notified and we're working to fix it.
                </p>

                @if(app()->isLocal() || config('app.debug'))
                    <div style="background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 1rem; margin: 2rem auto; text-align: left; border-radius: 0.375rem; max-width: 800px;">
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: #991b1b; margin-bottom: 0.5rem;">Error Details:</h3>
                        <div style="font-size: 0.875rem; color: #b91c1c;">
                            <p style="margin: 0.25rem 0;"><strong>Message:</strong> {{ $exception->getMessage() ?? 'No error message available' }}</p>
                            @if(isset($exception) && $exception->getFile())
                                <p style="margin: 0.25rem 0; font-size: 0.75rem; opacity: 0.75;">{{ $exception->getFile() }}:{{ $exception->getLine() }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="error-actions">
                    <a href="{{ url()->previous() }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem; background-color: white; color: #b91c1c; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-weight: 500; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                        <svg style="margin-right: 0.5rem; width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Go Back
                    </a>
                    <a href="{{ url('/') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem; background-color: #dc2626; color: white; border: 1px solid transparent; border-radius: 0.375rem; font-weight: 500; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                        <svg style="margin-right: 0.5rem; width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Return to Homepage
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="padding: 1.5rem; text-align: center; margin-top: auto;">
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">
                Need help? <a href="mailto:support@example.com" style="color: #dc2626; text-decoration: none; font-weight: 500;">Contact support</a>
            </p>
        </div>
    </div>
</body>
</html>
