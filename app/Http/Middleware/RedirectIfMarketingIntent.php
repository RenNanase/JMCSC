<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfMarketingIntent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Store a flag in the session if user is trying to access marketing routes
        if (str_contains($request->path(), 'marketing')) {
            Session::put('intended_marketing', true);
        }
        
        return $next($request);
    }
} 