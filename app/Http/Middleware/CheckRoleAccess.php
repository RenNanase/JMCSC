<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $intendedRole): Response
    {
        // If user is not authenticated, allow the request to proceed
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $currentRole = $user->role;

        // If user is already logged in with a different role
        if ($currentRole !== $intendedRole) {
            // Log out the user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login with appropriate message
            return redirect()->route('login')
                ->with('error', 'You are currently logged in as ' . ucfirst($currentRole) . '. Please log out first before accessing the ' . ucfirst($intendedRole) . ' dashboard.');
        }

        return $next($request);
    }
}
