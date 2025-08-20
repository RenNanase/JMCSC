<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPatients = Patient::count();
        $totalMembers = Member::count();
        $recentUsers = User::latest()->take(5)->get();
        $recentMembers = Member::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalPatients', 'totalMembers', 'recentUsers', 'recentMembers'));
    }
}
