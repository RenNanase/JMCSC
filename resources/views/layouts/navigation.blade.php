                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('User Management') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.patients.index')" :active="request()->routeIs('admin.patients.*')">
                            {{ __('Patient Management') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.eventMembers.index')" :active="request()->routeIs('admin.eventMembers.*')">
                            {{ __('Event Member Verification') }}
                        </x-nav-link>
                    @endif
