@extends('layouts.guest_app')

@section('content')
<!-- Login Section -->
<div class="mb-10 text-center">
    <h1 class="text-3xl md:text-4xl font-bold text-[#effcfb] mb-4">Login</h1>
    <p class="text-[#effcfb] max-w-2xl mx-auto">Access your JMC Senior Care account</p>
</div>

<!-- Login Form Area -->
<div class="max-w-md mx-auto">
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 bg-[#27a2a2]/10 border border-[#27a2a2]/20 rounded-lg text-[#27a2a2]">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6" id="login-form">
        @csrf

        <!-- Hidden field to store redirect information -->
        <input type="hidden" name="redirect_path" id="redirect_path" value="">

        <!-- Email Address -->
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-[#effcfb]">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-[#effcfb]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full pl-12 pr-4 py-3 border-0 bg-white/5 text-[#effcfb] placeholder-[#effcfb]/50 rounded-lg focus:ring-2 focus:ring-[#27a2a2]"
                    placeholder="Enter your email address">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-[#effcfb]">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-[#effcfb]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-12 pr-4 py-3 border-0 bg-white/5 text-[#effcfb] placeholder-[#effcfb]/50 rounded-lg focus:ring-2 focus:ring-[#27a2a2]"
                    placeholder="Enter your password">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full py-3 px-6 bg-[#2cacad] hover:bg-[#2cacad]/80 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center mt-4">
            Log in
            <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get both redirect parameters from URL
        const urlParams = new URLSearchParams(window.location.search);
        const redirectTo = urlParams.get('redirect_to');
        const redirectPath = urlParams.get('redirect_path');

        // Set the redirect path in the hidden input
        if (redirectPath) {
            document.getElementById('redirect_path').value = redirectPath;
        } else if (redirectTo) {
            document.getElementById('redirect_path').value = redirectTo;
        } else {
            // If no redirect parameters, check referrer
            const referrer = document.referrer;
            if (referrer) {
                const referrerUrl = new URL(referrer);
                const referrerPath = referrerUrl.pathname;

                // Set appropriate redirect path based on referrer
                if (referrerPath.includes('marketing')) {
                    document.getElementById('redirect_path').value = 'marketing.dashboard';
                } else if (referrerPath.includes('admin')) {
                    document.getElementById('redirect_path').value = 'admin.dashboard';
                }
            }
        }
    });
</script>
@endsection
