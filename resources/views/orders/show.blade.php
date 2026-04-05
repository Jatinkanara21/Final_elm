@extends('layouts.main')

@section('title', 'Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="bg-mocha-secondary py-8 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-4">
        <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl sm:text-3xl font-serif font-bold text-white">Order Details</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="glassmorphism rounded-xl border border-white/10 p-8">
        <div class="flex flex-col md:flex-row justify-between md:items-center mb-8 pb-8 border-b border-white/10">
            <div>
                <h2 class="text-xl font-bold text-white mb-1">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
                <p class="text-gray-400 text-sm">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div class="mt-4 md:mt-0 flex flex-col md:items-end">
                <p class="text-sm text-gray-400 mb-1">Status</p>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-mocha-accent/20 text-mocha-accent border border-mocha-accent/30 capitalize">
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <h3 class="text-lg font-bold text-white mb-6">Items Purchased</h3>
        <ul class="divide-y divide-white/5 mb-8">
            @foreach($order->items as $item)
                <li class="py-4 flex">
                    @if($item->product->image)
                        <img src="{{ Storage::url($item->product->image) }}" class="h-20 w-20 rounded object-contain bg-black/40 border border-white/5 p-2">
                    @else
                        <div class="h-20 w-20 rounded bg-mocha-accent/20 border-2 border-mocha-accent/40 flex items-center justify-center"></div>
                    @endif
                    <div class="ml-4 flex-1 flex flex-col justify-center">
                        <a href="{{ route('products.show', $item->product) }}" class="text-base font-bold text-white hover:text-mocha-accent transition-colors">
                            {{ $item->product->name }}
                        </a>
                        <div class="mt-1 text-sm text-gray-400 font-mono">
                            ${{ number_format($item->price, 2) }} x {{ $item->quantity }}
                        </div>
                    </div>
                    <div class="ml-4 flex flex-col items-end justify-center">
                        <span class="font-bold text-white">${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="flex justify-end pt-6 border-t border-white/10">
            <dl class="w-full sm:w-1/2 lg:w-1/3 text-sm">
                <div class="py-2 flex justify-between">
                    <dt class="text-gray-400">Subtotal</dt>
                    <dd class="text-white font-medium">${{ number_format($order->subtotal, 2) }}</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="text-gray-400">Tax</dt>
                    <dd class="text-white font-medium">${{ number_format($order->tax, 2) }}</dd>
                </div>
                <div class="py-3 flex justify-between border-t border-white/10 mt-2">
                    <dt class="text-lg font-bold text-white">Total</dt>
                    <dd class="text-xl font-bold text-mocha-accent">${{ number_format($order->total, 2) }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
