<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership; // Import the Membership model

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();
        $userName = $user ? $user->name : 'Guest';

        // Get count data for the dashboard
        $totalMembers = Membership::count();
        $activeMembers = Membership::where('status', 'active')->count();
        $newThisMonth = Membership::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('marketing.dashboard', compact('totalMembers', 'activeMembers', 'newThisMonth', 'userName'));
    }
} 