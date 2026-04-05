@extends('layouts.main')

@section('title', 'Order History')

@section('content')
<div class="bg-mocha-secondary py-8 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-4">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Order History</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($orders->count() > 0)
        <div class="flex flex-col space-y-8">
            @foreach($orders as $order)
                <div class="glassmorphism rounded-xl overflow-hidden border border-white/10">
                    <div class="bg-black/30 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between border-b border-white/5">
                        <div class="flex flex-col sm:flex-row sm:space-x-8">
                            <div class="mb-2 sm:mb-0">
                                <span class="text-xs text-mocha-accent uppercase font-bold tracking-wider">Date Placed</span>
                                <p class="text-white font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="mb-2 sm:mb-0">
                                <span class="text-xs text-mocha-accent uppercase font-bold tracking-wider">Total Amount</span>
                                <p class="text-white font-medium">${{ number_format($order->total, 2) }}</p>
                            </div>
                            <div class="mb-2 sm:mb-0">
                                <span class="text-xs text-mocha-accent uppercase font-bold tracking-wider">Order DB-ID</span>
                                <p class="text-white font-medium">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-800 text-gray-300 border border-white/10 capitalize">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <ul class="divide-y divide-white/5">
                            @foreach($order->items as $item)
                                <li class="py-4 flex">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" class="h-20 w-20 rounded object-contain bg-black/40 border border-white/5 p-2">
                                    @else
                                        <div class="h-20 w-20 rounded bg-mocha-accent/20 border-2 border-mocha-accent/40 flex items-center justify-center"></div>
                                    @endif
                                    <div class="ml-4 flex-1 flex flex-col justify-center">
                                        <a href="{{ route('products.show', $item->product) }}" class="text-base font-bold text-white hover:text-mocha-accent transition-colors line-clamp-1">
                                            {{ $item->product->name }}
                                        </a>
                                        <div class="mt-1 text-sm text-gray-400 flex items-center justify-between w-full sm:w-1/2">
                                            <span>Qty: {{ $item->quantity }}</span>
                                            <span class="font-medium text-mocha-light">${{ number_format($item->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 hidden sm:flex flex-col items-end justify-center">
                                        <a href="{{ route('products.show', $item->product) }}" class="text-sm text-mocha-accent hover:text-white transition-colors border border-mocha-accent px-4 py-1.5 rounded">Buy Again</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-24 glassmorphism rounded-xl border border-white/5">
            <svg class="mx-auto h-16 w-16 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h2 class="text-2xl font-serif font-bold text-white mb-2">No Order History</h2>
            <p class="text-gray-400 mb-8">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="inline-flex justify-center items-center bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-all">
                Shop Now
            </a>
        </div>
    @endif
</div>
@endsection
