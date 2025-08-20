<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#27a2a2] leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#eefbf9] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-[#27a2a2]">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Check if we should redirect to marketing dashboard
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('redirect_to_marketing') === 'true') {
                // Clear the flag
                localStorage.removeItem('redirect_to_marketing');

                // Redirect to marketing dashboard
                window.location.href = "{{ route('marketing.dashboard') }}";
            }
        });
    </script>
</x-app-layout>
