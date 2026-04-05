@extends('layouts.main')

@section('title', 'My Wishlist')

@section('content')
<div class="bg-mocha-secondary py-8 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-4">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">My Wishlist</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($wishlists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
                <div class="group glassmorphism rounded-xl overflow-hidden shadow-lg border border-white/5 flex flex-col h-full relative">
                    
                    <!-- Remove Button -->
                    <form action="{{ route('wishlist.remove', $wishlist->product_id) }}" method="POST" class="absolute top-2 right-2 z-10">
                        @csrf
                        <button type="submit" class="bg-black/50 text-gray-400 hover:text-red-500 rounded-full p-2 backdrop-blur-sm transition-colors" title="Remove">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </form>
                    
                    <div class="relative h-48 bg-black/40 p-4 flex justify-center items-center overflow-hidden">
                        @if($wishlist->product->image)
                            <img src="{{ Storage::url($wishlist->product->image) }}" alt="{{ $wishlist->product->name }}" class="h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-16 h-32 bg-mocha-accent/20 rounded-t-full rounded-b-lg border-2 border-mocha-accent/40 flex items-center justify-center"></div>
                        @endif
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <a href="{{ route('products.show', $wishlist->product) }}" class="block">
                            <h4 class="text-lg font-serif font-bold text-white hover:text-mocha-accent transition-colors line-clamp-2">{{ $wishlist->product->name }}</h4>
                        </a>
                        
                        <div class="flex items-center gap-2 mt-auto pt-4 border-t border-white/10">
                            <span class="text-lg font-bold text-white">${{ number_format($wishlist->product->price, 2) }}</span>
                            @if($wishlist->product->retail_price && $wishlist->product->retail_price > $wishlist->product->price)
                                <span class="text-xs text-gray-400 line-through">${{ number_format($wishlist->product->retail_price, 2) }}</span>
                            @endif
                            <div class="flex-grow"></div>
                            <form action="{{ route('cart.add', $wishlist->product) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-mocha-accent hover:bg-[#A0522D] shadow-lg text-white rounded-full p-2 transition-transform transform hover:-translate-y-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-24 glassmorphism rounded-xl border border-white/5">
            <svg class="mx-auto h-16 w-16 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h2 class="text-2xl font-serif font-bold text-white mb-2">Your wishlist is empty</h2>
            <p class="text-gray-400 mb-8">Save items you love so you don't lose track of them.</p>
            <a href="{{ route('products.index') }}" class="inline-flex justify-center items-center bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-all">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
