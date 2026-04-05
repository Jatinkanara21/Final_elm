@extends('layouts.main')

@section('title', 'Shop')

@section('content')
<div class="bg-white/80 py-8 border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-serif font-bold text-mocha-text">Our Collection</h1>
        <p class="text-gray-600 mt-2">Explore our premium selection.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <div class="w-full lg:w-1/4">
            <div class="glassmorphism rounded-xl p-6 sticky top-28 bg-white/90">
                <h3 class="text-lg font-bold text-mocha-text mb-6 border-b border-gray-100 pb-4">Filters</h3>
                
                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                    </div>

                    <!-- Categories -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-3 px-4 rounded-md transition-colors shadow-sm">
                        Apply Filters
                    </button>
                    
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('products.index') }}" class="block text-center w-full mt-3 text-sm text-gray-500 hover:text-mocha-accent">Clear All</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="w-full lg:w-3/4">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="group glassmorphism rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col h-full bg-white">
                            <div class="relative h-56 bg-gray-50 p-4 flex justify-center items-center overflow-hidden border-b border-gray-100">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full object-contain group-hover:scale-110 transition-transform duration-500 drop-shadow-md">
                                @else
                                    <div class="w-16 h-32 bg-mocha-accent/10 rounded-t-full rounded-b border border-mocha-accent/30 flex items-center justify-center"></div>
                                @endif
                            </div>
                            
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="text-[10px] text-mocha-accent uppercase tracking-wider mb-1 font-bold">{{ $product->category->name ?? '' }}</div>
                                <a href="{{ route('products.show', $product) }}" class="block mt-1">
                                    <h4 class="text-base font-serif font-bold text-mocha-text hover:text-mocha-accent transition-colors line-clamp-2">{{ $product->name }}</h4>
                                </a>
                                
                                <div class="flex items-center gap-2 mt-auto pt-4 border-t border-gray-100">
                                    <div class="flex-grow"></div>
                                    <a href="{{ route('products.show', $product) }}" class="bg-mocha-accent hover:bg-[#A0522D] text-white rounded-full px-4 py-2 text-sm font-bold transition-colors shadow-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            @else
                <div class="text-center py-24 glassmorphism rounded-xl">
                    <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-white">No products found</h3>
                    <p class="mt-2 text-gray-400 text-sm">We couldn't find anything matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
