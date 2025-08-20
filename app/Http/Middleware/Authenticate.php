<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Get the intended URL
            $intended = $request->session()->get('url.intended');

            // If the intended URL contains 'marketing', redirect to login with marketing parameter
            if ($intended && str_contains($intended, '/marketing')) {
                return route('login', ['redirect_to' => 'marketing.dashboard']);
            }

            // If the intended URL contains 'admin', redirect to login with admin parameter
            if ($intended && str_contains($intended, '/admin')) {
                return route('login', ['redirect_to' => 'admin.dashboard']);
            }

            // Default redirect to login
            return route('login');
        }

        return null;
    }
}
