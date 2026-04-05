@extends('admin.layout')

@section('title', 'Homepage Settings')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-serif font-bold text-mocha-text">Homepage Settings</h1>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center shadow-sm">
        <svg class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 8"></path></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Hero Image Upload Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
            <h2 class="text-lg font-bold text-mocha-text mb-2">Hero Background Image</h2>
            <p class="text-sm text-gray-500 mb-4">Adjust the primary wide background banner for the homepage.</p>
            
            <div class="relative rounded-xl overflow-hidden mb-4 aspect-video bg-gray-50 border border-gray-100 flex items-center justify-center">
                @if(file_exists(public_path('images/homepage/hero.jpg')))
                    <img src="{{ asset('images/homepage/hero.jpg') }}?v={{ time() }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center p-6 text-gray-400">
                        <svg class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-sm font-medium">No custom hero image found.</p>
                        <p class="text-xs mt-1">Falling back to static Unsplash URL.</p>
                    </div>
                @endif
            </div>

            <form action="{{ route('admin.settings.updateImages') }}" method="POST" enctype="multipart/form-data" class="mt-auto">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="file" name="home_hero_bg" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-mocha-accent/10 file:text-mocha-accent hover:file:bg-mocha-accent/20 cursor-pointer">
                    <button type="submit" class="bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition-colors whitespace-nowrap">
                        Upload
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection
