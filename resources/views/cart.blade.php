@extends('layouts.main')

@section('title', 'Shopping Cart')

@section('content')
<div class="bg-white/80 py-8 border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-serif font-bold text-mocha-text">Your Cart</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(session('cart') && count(session('cart')) > 0)
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Cart Items -->
            <div class="w-full lg:w-2/3">
                <div class="glassmorphism rounded-xl border border-gray-100 overflow-hidden bg-white">
                    <ul role="list" class="divide-y divide-gray-100">
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <li class="p-6 flex py-6 sm:py-10">
                                <div class="flex-shrink-0">
                                    @if(isset($details['image']) && $details['image'])
                                        <img src="{{ Storage::url($details['image']) }}" alt="{{ $details['name'] }}" class="w-24 h-24 rounded-md object-contain sm:w-32 sm:h-32 bg-gray-50 border border-gray-100 p-2">
                                    @else
                                        <div class="w-24 h-24 rounded-md sm:w-32 sm:h-32 bg-mocha-accent/20 border border-mocha-accent/40 flex items-center justify-center">
                                            <span class="text-mocha-accent/50 text-xs">NO IMAGE</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                    <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                        <div>
                                            <div class="flex justify-between">
                                                <h3 class="text-lg">
                                                    <a href="{{ route('products.show', $id) }}" class="font-serif font-bold text-mocha-text hover:text-mocha-accent">{{ $details['name'] }}</a>
                                                </h3>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <p class="text-sm font-bold text-mocha-accent">${{ number_format($details['price'], 2) }}</p>
                                                @if(isset($details['retail_price']) && $details['retail_price'] > $details['price'])
                                                    <p class="text-xs text-gray-400 line-through">${{ number_format($details['retail_price'], 2) }}</p>
                                                    <span class="text-[10px] bg-green-50 text-green-600 px-1.5 py-0.5 rounded font-bold">
                                                        -{{ round((($details['retail_price'] - $details['price']) / $details['retail_price']) * 100) }}%
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-4 sm:mt-0 sm:pr-9 flex items-center justify-start sm:justify-end space-x-4">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <select name="quantity" onchange="this.form.submit()" class="max-w-full rounded-md border border-gray-200 py-1.5 text-left text-base font-medium text-gray-800 shadow-sm focus:border-mocha-accent focus:outline-none focus:ring-1 focus:ring-mocha-accent sm:text-sm bg-white">
                                                    @for($i=1; $i<=10; $i++)
                                                        <option value="{{ $i }}" {{ $details['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </form>

                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-1/3">
                <div class="glassmorphism rounded-xl p-6 border border-gray-100 sticky top-28 bg-white">
                    <h2 class="text-lg font-bold text-mocha-text mb-4">Order Summary</h2>
                    
                    <div class="flow-root">
                        <dl class="-my-4 text-sm divide-y divide-gray-100">
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-gray-600">Subtotal</dt>
                                <dd class="font-medium text-mocha-text">${{ number_format($total, 2) }}</dd>
                            </div>
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-gray-600">Shipping</dt>
                                <dd class="font-medium text-mocha-text">Calculated at checkout</dd>
                            </div>
                            <div class="py-4 flex items-center justify-between">
                                <dt class="text-base font-bold text-mocha-text">Order Total</dt>
                                <dd class="text-xl font-bold text-mocha-accent">${{ number_format($total, 2) }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-8">
                        @auth
                            <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-4 px-4 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
                                Proceed to Checkout
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full flex justify-center items-center bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-4 px-4 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
                                Login to Checkout
                            </a>
                        @endauth
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-mocha-accent transition-colors">
                            or <span class="text-mocha-accent hover:underline">Continue Shopping &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Checkout (Mobile overlay) -->
            <div class="fixed bottom-14 left-0 right-0 bg-white border-t border-gray-100 p-4 shadow-lg z-40 sm:hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-600">Total:</span>
                    <span class="text-xl font-bold text-mocha-accent">${{ number_format($total, 2) }}</span>
                </div>
                @auth
                    <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-3 px-4 rounded-lg shadow-md transition">
                        Proceed to Checkout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full flex justify-center items-center bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-3 px-4 rounded-lg shadow-md transition">
                        Login to Checkout
                    </a>
                @endauth
            </div>

        </div>
    @else
        <div class="text-center py-24 glassmorphism rounded-xl border border-gray-100 bg-white">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h2 class="text-2xl font-serif font-bold text-mocha-text mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added any premium selections yet.</p>
            <a href="{{ route('products.index') }}" class="inline-flex justify-center items-center bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-all">
                Explore Collection
            </a>
        </div>
    @endif
</div>
@endsection
