@extends('layouts.main')

@section('title', 'Welcome to Elm Grove')

@section('content')
<!-- Hero Section -->
<div class="relative bg-mocha-dark overflow-hidden">
    <div class="absolute inset-0">
        <!-- We use an image placeholder generated or from Unsplash if possible, but let's use a pure CSS gradient that feels like a dark whiskey cellar -->
        <div class="absolute inset-0 bg-gradient-to-br from-mocha-dark via-[#2b1709] to-mocha-secondary opacity-90"></div>
        <!-- Dynamic Hero Background -->
        @if(file_exists(public_path('images/homepage/hero.jpg')))
            <div class="absolute inset-0 bg-[url('{{ asset('images/homepage/hero.jpg') }}?v={{ time() }}')] bg-cover bg-center mix-blend-overlay opacity-40"></div>
        @else
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1569529465841-dfecdab7503b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center mix-blend-overlay opacity-30"></div>
        @endif
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 lg:py-48 flex items-center h-full">
        <div class="max-w-2xl">
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold font-serif text-mocha-light leading-tight">
                Discover <span class="text-mocha-accent italic">Rare</span> & <br>Exceptional Spirits
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-gray-300 max-w-xl">
                Curated collection of the world's finest whiskies, premium wines, and top-shelf liquor. Delivered directly to your door.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('products.index') }}" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-base font-bold rounded-md text-white bg-mocha-accent hover:bg-[#A0522D] shadow-[0_0_20px_rgba(139,69,19,0.4)] transition-all transform hover:-translate-y-1">
                    Shop Collection
                </a>
                <a href="#featured" class="inline-flex justify-center items-center px-8 py-4 border border-white/20 text-base font-bold rounded-md text-mocha-light bg-black/40 hover:bg-black/60 backdrop-blur-md transition-all">
                    View Featured
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories / Info -->
<div class="bg-white/80 py-12 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <div class="p-6">
                <h3 class="text-xl font-serif text-mocha-accent mb-2">Curated Selection</h3>
                <p class="text-gray-600 text-sm">Every bottle is hand-picked by our expert sommeliers and connoisseurs.</p>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-serif text-mocha-accent mb-2">Secure Packaging</h3>
                <p class="text-gray-600 text-sm">Specialized temperature-controlled packaging ensures safe arrival.</p>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-serif text-mocha-accent mb-2">Premium Support</h3>
                <p class="text-gray-600 text-sm">Dedicated customer service designed for your premium experience.</p>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div id="featured" class="py-24 bg-mocha-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-[0.2em] mb-3">Handpicked For You</h2>
            <h3 class="text-4xl font-serif text-mocha-text">Featured Arrivals</h3>
            <div class="w-16 h-1 bg-mocha-accent mx-auto mt-6"></div>
        </div>

        @if($featuredProducts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                <div class="group glassmorphism rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 hover:border-mocha-accent/30 flex flex-col h-full">
                    <div class="relative h-64 bg-gray-50 p-6 flex justify-center items-center overflow-hidden border-b border-gray-100/50">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full object-contain group-hover:scale-110 transition-transform duration-500 drop-shadow-md">
                        @else
                            <div class="w-24 h-48 bg-mocha-accent/10 rounded-t-full rounded-b-lg border-2 border-mocha-accent/30 flex items-center justify-center">
                                <span class="text-mocha-accent/50 text-xs font-serif rotate-90">{{ $product->category->name ?? 'BOTTLE' }}</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-4 right-4">
                            <form action="{{ route('wishlist.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-mocha-accent transition-colors bg-white shadow-sm p-2 rounded-full">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-xs text-mocha-accent uppercase tracking-wider mb-2 font-bold">{{ $product->category->name ?? '' }}</div>
                        <a href="{{ route('products.index') }}" class="block mt-1">
                            <h4 class="text-lg font-serif font-bold text-mocha-text hover:text-mocha-accent transition-colors line-clamp-2">{{ $product->name }}</h4>
                        </a>
                        <p class="text-sm text-gray-600 mt-2 mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                            <div class="flex-grow"></div>
                            <a href="{{ route('products.show', $product) }}" class="bg-mocha-accent hover:bg-[#A0522D] text-white rounded-full px-4 py-2 text-xs font-bold transition-colors shadow-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-16 text-center">
            <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 text-mocha-accent hover:text-[#A0522D] font-bold transition-colors group">
                <span>View Full Collection</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        @else
        <div class="text-center text-gray-400 py-12 glassmorphism rounded-xl">
            <p>No products available yet. Please check back soon.</p>
        </div>
        @endif
    </div>
</div>

@endsection
