@extends('admin.layout')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-serif font-bold text-mocha-text mb-1">Dashboard Overview</h1>
        <p class="text-gray-500 text-sm">Welcome to the Elm Grove administration panel.</p>
    </div>
    
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 relative overflow-hidden group shadow-sm hover:shadow-md transition-shadow col-span-1">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/5 rounded-full group-hover:bg-purple-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
        <p class="text-2xl font-bold text-mocha-text">{{ number_format($totalProducts) }}</p>
    </div>
    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 relative overflow-hidden group shadow-sm hover:shadow-md transition-shadow col-span-1 lg:col-span-1">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-500/5 rounded-full group-hover:bg-green-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-50 rounded-xl text-green-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-500 mb-1">Registered Users</p>
        <p class="text-2xl font-bold text-mocha-text">{{ number_format($totalUsers) }}</p>
    </div>
</div>

@endsection
