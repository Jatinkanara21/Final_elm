<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elm Grove Liquor') }} - @yield('title', 'Premium Liquor Store')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-mocha-light text-mocha-text font-sans antialiased flex flex-col min-h-screen pb-10 sm:pb-0">
    <x-age-gate />

    <!-- Navigation -->
    <nav x-data="{ open: false }" class="bg-mocha-dark border-b border-white/10 shadow-2xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16"> 
                <!-- Branding & Logo (Left) -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center">
                        <div class="relative">
                            <!-- Subtle glow effect behind the logo on hover -->
                            <div class="absolute -inset-2 bg-mocha-accent/20 rounded-full blur-md opacity-0 group-hover:opacity-100 transition duration-700"></div>
                            <img src="/img/logo.png" alt="Elm Grove Liquor" class="relative h-14 w-auto object-contain drop-shadow-xl transition-all duration-500 group-hover:scale-105">
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links (Centered & Separated) -->
                <div class="hidden sm:flex sm:items-center">
                    <a href="{{ route('home') }}" class="relative group py-2 px-6 text-xs font-bold uppercase tracking-[0.3em] transition-colors {{ request()->routeIs('home') ? 'text-mocha-accent' : 'text-gray-300 hover:text-mocha-accent' }}">
                        Home
                        <span class="absolute bottom-0 left-6 right-6 h-0.5 bg-mocha-accent transform {{ request()->routeIs('home') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                    </a>
                    <div class="h-4 w-px bg-white/10 mx-2"></div>
                    <a href="{{ route('products.index') }}" class="relative group py-2 px-6 text-xs font-bold uppercase tracking-[0.3em] transition-colors {{ request()->routeIs('products.*') ? 'text-mocha-accent' : 'text-gray-300 hover:text-mocha-accent' }}">
                        Collection
                        <span class="absolute bottom-0 left-6 right-6 h-0.5 bg-mocha-accent transform {{ request()->routeIs('products.*') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                    </a>
                    <div class="h-4 w-px bg-white/10 mx-2"></div>
                    <a href="{{ route('reviews.index') }}" class="relative group py-2 px-6 text-xs font-bold uppercase tracking-[0.3em] transition-colors {{ request()->routeIs('reviews.*') ? 'text-mocha-accent' : 'text-gray-300 hover:text-mocha-accent' }}">
                        Reviews
                        <span class="absolute bottom-0 left-6 right-6 h-0.5 bg-mocha-accent transform {{ request()->routeIs('reviews.*') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                    </a>
                </div>

                <!-- Desktop Action Buttons (Right) -->
                <div class="hidden sm:flex sm:items-center space-x-6">
                    @auth
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-3 p-1.5 rounded-full hover:bg-white/5 transition-all border border-transparent hover:border-mocha-accent/10 focus:outline-none">
                                <div class="w-9 h-9 rounded-full bg-mocha-accent/20 border border-mocha-accent/30 flex items-center justify-center text-mocha-accent text-sm font-bold shadow-inner">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="hidden lg:flex flex-col items-start mr-2">
                                    <span class="text-xs font-bold text-mocha-light">{{ auth()->user()->name }}</span>
                                    <span class="text-[9px] text-mocha-accent font-bold uppercase tracking-tighter">{{ auth()->user()->is_admin ? 'Admin Access' : 'Member' }}</span>
                                </div>
                                <svg class="w-4 h-4 text-mocha-accent/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-3 w-56 bg-mocha-secondary rounded-xl shadow-2xl py-2 border border-white/5 z-50 overflow-hidden" style="display: none;">
                                <div class="px-4 py-2 border-b border-white/5 mb-1">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Account & Settings</p>
                                </div>
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-mocha-accent transition-colors group">
                                        <svg class="w-4 h-4 mr-3 text-mocha-accent/60 group-hover:text-mocha-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        Control Center
                                    </a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-mocha-accent transition-colors group">
                                    <svg class="w-4 h-4 mr-3 text-mocha-accent/60 group-hover:text-mocha-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    My Profile
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-mocha-accent transition-colors group">
                                    <svg class="w-4 h-4 mr-3 text-mocha-accent/60 group-hover:text-mocha-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    Curated Wishlist
                                </a>
                                <div class="border-t border-white/5 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-400 hover:bg-red-950/20 transition-colors group">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1"></path></svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-widest text-gray-300 hover:text-mocha-accent transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="bg-mocha-accent hover:bg-mocha-accent/90 text-white px-6 py-2.5 rounded-full text-sm font-bold uppercase tracking-widest transition-all shadow-lg shadow-mocha-accent/20 hover:shadow-mocha-accent/30 transform hover:-translate-y-0.5">Register</a>
                        </div>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-3 rounded-xl text-mocha-accent bg-white/5 border border-white/10 hover:bg-white/10 shadow-sm focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu side drawer/overlay approach -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="sm:hidden border-t border-white/5 bg-mocha-dark shadow-2xl relative z-40" 
             style="display: none;">
            <div class="pt-4 pb-6 px-4 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('home') ? 'bg-white/5 text-mocha-accent' : 'text-gray-300 hover:bg-white/5' }} transition-all">
                    <span class="text-base font-bold uppercase tracking-[0.2em]">Home</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('products.*') ? 'bg-white/5 text-mocha-accent' : 'text-gray-300 hover:bg-white/5' }} transition-all">
                    <span class="text-base font-bold uppercase tracking-[0.2em]">Shop Collection</span>
                </a>
                <a href="{{ route('reviews.index') }}" class="flex items-center p-3 rounded-xl {{ request()->routeIs('reviews.*') ? 'bg-white/5 text-mocha-accent' : 'text-gray-300 hover:bg-white/5' }} transition-all">
                    <span class="text-base font-bold uppercase tracking-[0.2em]">Customer Reviews</span>
                </a>
                
                @guest
                    <div class="pt-6 mt-6 border-t border-white/5 grid grid-cols-2 gap-4">
                        <a href="{{ route('login') }}" class="flex justify-center items-center py-3 border border-white/10 rounded-xl text-sm font-bold uppercase tracking-widest text-gray-300">Log in</a>
                        <a href="{{ route('register') }}" class="flex justify-center items-center py-3 bg-mocha-accent rounded-xl text-sm font-bold uppercase tracking-widest text-white shadow-md">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-600/20 border border-green-500 text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-600/20 border border-red-500 text-red-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-mocha-dark border-t border-white/10 mt-6 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="flex flex-col">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('img/logo.png') }}" alt="Elm Grove" class="h-14 w-auto brightness-0 invert opacity-80 group-hover:opacity-100 transition-opacity">
                        <span class="font-serif text-2xl font-bold text-white">Elm Grove</span>
                    </div>
                    <p class="mt-4 text-gray-500 text-xs tracking-[0.3em] uppercase mb-4">Liquor Store</p>
                    <p class="text-gray-400 text-sm max-w-sm">Premium fine wines, spirits, and craft beers. Experience luxury with every pour. Drink responsibly.</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Quick Links</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white text-sm">Shop</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Contact</h3>
                    <ul class="mt-4 space-y-2 text-sm text-gray-400">
                        <li>7433 N Lindbergh Blvd</li>
                        <li>Hazelwood, MO 63042</li>
                        <li>United States</li>
                        <li class="pt-1">Phone: (555) 123-4567</li>
                        <li>Email: info@elmgroveliquor.com</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Location</h3>
                    <div class="mt-4 rounded-xl overflow-hidden border border-white/5 h-36">
                        <iframe class="w-full h-full" src="https://maps.google.com/maps?q=7433%20N%20Lindbergh%20Blvd,%20Hazelwood,%20MO%2063042&t=&z=14&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-white/10 pt-8 flex items-center justify-between">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Elm Grove Liquor Store. All rights reserved.</p>
                <div class="flex space-x-6">
                    <p class="text-gray-500 text-xs">Must be 21+ to purchase.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation (Mobile App-style) -->
    <div class="fixed bottom-0 left-0 right-0 bg-mocha-dark border-t border-white/10 shadow-2xl flex justify-around p-3 z-50 sm:hidden">
        <a href="{{ route('home') }}" class="flex flex-col items-center {{ request()->routeIs('home') ? 'text-mocha-accent' : 'text-gray-400 hover:text-mocha-accent' }} transition-colors">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span class="text-[10px] mt-1 font-bold uppercase tracking-widest">Home</span>
        </a>
        <a href="{{ route('products.index') }}" class="flex flex-col items-center {{ request()->routeIs('products.*') ? 'text-mocha-accent' : 'text-gray-400 hover:text-mocha-accent' }} transition-colors">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <span class="text-[10px] mt-1 font-bold uppercase tracking-widest">Search</span>
        </a>
        <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center {{ request()->routeIs('wishlist.*') ? 'text-mocha-accent' : 'text-gray-400 hover:text-mocha-accent' }} transition-colors">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
            <span class="text-[10px] mt-1 font-bold uppercase tracking-widest">Wishlist</span>
        </a>
        @auth
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-mocha-accent' : 'text-gray-400 hover:text-mocha-accent' }} transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                <span class="text-[10px] mt-1 font-bold uppercase tracking-widest">Profile</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center {{ request()->routeIs('login') ? 'text-mocha-accent' : 'text-gray-400 hover:text-mocha-accent' }} transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1" /></svg>
                <span class="text-[10px] mt-1 font-bold uppercase tracking-widest">Login</span>
            </a>
        @endauth
    </div>
</body>
</html>
