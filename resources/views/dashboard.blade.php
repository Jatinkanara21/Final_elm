@extends('layouts.main')

@section('title', 'My Dashboard')

@section('content')
<div class="bg-mocha-secondary py-8 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <h1 class="text-3xl font-serif font-bold text-white">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
        @if(auth()->user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition-colors">Go to Admin Panel</a>
        @endif
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        
        <div class="glassmorphism rounded-xl border border-white/10 p-8 flex flex-col justify-center items-center text-center">
            <div class="h-16 w-16 bg-mocha-accent/20 text-mocha-accent rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <h3 class="text-xl font-serif text-white mb-2">My Wishlist</h3>
            <p class="text-sm text-gray-400 mb-6">Save your favorite premium selections for later.</p>
            <a href="{{ route('wishlist.index') }}" class="mt-auto px-6 py-2 border border-mocha-accent text-mocha-accent hover:bg-mocha-accent hover:text-white rounded-md transition-colors font-medium text-sm">View Wishlist</a>
        </div>
        
        <div class="glassmorphism rounded-xl border border-white/10 p-8 flex flex-col justify-center items-center text-center">
            <div class="h-16 w-16 bg-mocha-accent/20 text-mocha-accent rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h3 class="text-xl font-serif text-white mb-2">Account Settings</h3>
            <p class="text-sm text-gray-400 mb-6">Manage your profile, password, and preferences.</p>
            <a href="{{ route('profile.edit') }}" class="mt-auto px-6 py-2 border border-mocha-accent text-mocha-accent hover:bg-mocha-accent hover:text-white rounded-md transition-colors font-medium text-sm">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
