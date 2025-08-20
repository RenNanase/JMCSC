<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Check if there's a redirect path in the request
                if ($request->has('redirect_path')) {
                    $redirectPath = $request->input('redirect_path');

                    // Handle specific redirect paths based on user role
                    if ($redirectPath === 'marketing.dashboard' && ($user->role === 'marketing' || $user->role === 'user')) {
                        return redirect()->route('marketing.dashboard');
                    } elseif ($redirectPath === 'admin.dashboard' && $user->role === 'admin') {
                        return redirect()->route('admin.dashboard');
                    }
                }

                // Default redirects based on user role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'marketing' || $user->role === 'user') {
                    return redirect()->route('marketing.dashboard');
                }

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
