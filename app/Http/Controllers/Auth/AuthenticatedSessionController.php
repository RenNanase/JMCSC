<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Get redirect path from either form input or URL parameter
        $redirectPath = $request->input('redirect_path') ?? $request->query('redirect_to');

        // Handle specific redirect paths
        if ($redirectPath) {
            if ($redirectPath === 'marketing.dashboard' && ($user->role === 'marketing' || $user->role === 'user')) {
                return redirect()->route('marketing.dashboard');
            } elseif ($redirectPath === 'admin.dashboard' && $user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        // If no redirect_path or invalid role, check user role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'marketing' || $user->role === 'user') {
            return redirect()->route('marketing.dashboard');
        }

        // If user has no specific role, redirect to welcome page
        return redirect()->route('welcome');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
