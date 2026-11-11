<nav x-data="{
        open: false,
        greeting: '',
        icon: '',
        updateGreeting() {
            const hour = new Date().getHours();
            if (hour >= 5 && hour < 11) {
                this.greeting = 'Selamat Pagi';
                this.icon = '☀️';
            } else if (hour >= 11 && hour < 15) {
                this.greeting = 'Selamat Siang';
                this.icon = '🌤️';
            } else if (hour >= 15 && hour < 18) {
                this.greeting = 'Selamat Sore';
                this.icon = '🌇';
            } else {
                this.greeting = 'Selamat Malam';
                this.icon = '🌙';
            }
        }
    }"
    x-init="updateGreeting(); setInterval(() => updateGreeting(), 60000)"
    class="bg-white border-b border-emerald-100/60 shadow-sm">

    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-emerald-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 border border-emerald-100 text-xs lg:text-sm leading-4 font-semibold rounded-xl text-emerald-950 bg-emerald-50/40 hover:bg-emerald-50 focus:outline-none transition ease-in-out duration-150">
                            <!-- Emoji Beranimasi Smooth Bounce -->
                            <span x-text="icon" class="text-base animate-bounce"></span>

                            <!-- Teks Sapaan & Nama User -->
                            <div class="flex items-center gap-1">
                                <span x-text="greeting" class="text-emerald-700 font-medium"></span>,
                                <span class="font-bold text-emerald-950 tracking-tight">{{ Auth::user()->name }}</span>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-emerald-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-emerald-100">
            <div class="px-4 flex items-center gap-2">
                <span x-text="icon" class="text-lg"></span>
                <div>
                    <div class="font-bold text-sm text-emerald-950">
                        <span x-text="greeting" class="text-emerald-700 font-medium"></span>, {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
