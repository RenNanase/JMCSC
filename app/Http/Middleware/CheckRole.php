<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Special case for marketing department - allow users with 'user' role
        if (in_array('marketing', $roles) && $user->role === 'user') {
            return $next($request);
        }

        // For other roles, check normally
        if (!in_array($user->role, $roles)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
