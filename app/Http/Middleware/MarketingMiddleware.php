<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MarketingMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login', ['redirect_path' => 'marketing.dashboard']);
        }

        $user = Auth::user();

        // If user is not a marketing user
        if ($user->role !== 'marketing' && $user->role !== 'user') {
            // Log out the user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login with appropriate message
            return redirect()->route('login')
                ->with('error', 'You do not have permission to access the marketing area.');
        }

        return $next($request);
    }
}
