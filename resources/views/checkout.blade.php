@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
<div class="bg-white/80 py-8 border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-serif font-bold text-mocha-text">Secure Checkout</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        
        <!-- Checkout Form -->
        <div class="w-full lg:w-2/3">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                <div class="glassmorphism rounded-xl border border-gray-100 p-8 mb-8 bg-white">
                    <h2 class="text-xl font-bold text-mocha-text mb-6 border-b border-gray-100 pb-4">Shipping Information</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" value="{{ explode(' ', auth()->user()->name)[0] }}" required class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" value="{{ count(explode(' ', auth()->user()->name)) > 1 ? explode(' ', auth()->user()->name)[1] : '' }}" required class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" required class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" required class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                            <input type="text" required class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ZIP</label>
                            <input type="text" required class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent">
                        </div>
                    </div>
                </div>

                <div class="glassmorphism rounded-xl border border-gray-100 p-8 bg-white">
                    <h2 class="text-xl font-bold text-mocha-text mb-6 border-b border-gray-100 pb-4">Payment Details</h2>

                    <div class="mb-4">
                        <div class="bg-gray-50 border border-gray-100 rounded p-4 flex items-center justify-between cursor-pointer hover:bg-gray-100 transition shadow-sm">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" checked class="text-mocha-accent bg-white border-gray-300 focus:ring-mocha-accent">
                                <label class="ml-3 text-mocha-text font-medium">Credit Card (Stripe Mock)</label>
                            </div>
                            <div class="flex space-x-2">
                                <svg class="h-8 shadow-sm" viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="24" rx="4" fill="#6772E5"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-500 mt-4">
                        <p>This is a simulated checkout. Simply click 'Complete Order' below.</p>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-4 px-4 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
                            Complete Secure Order
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-1/3">
            <div class="glassmorphism rounded-xl p-6 border border-gray-100 bg-white sticky top-28">
                <h2 class="text-lg font-bold text-mocha-text mb-6 border-b border-gray-100 pb-4">Order Summary</h2>
                
                <ul class="divide-y divide-gray-100 mb-6 max-h-96 overflow-y-auto pr-2">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <li class="py-4 flex">
                            @if(isset($details['image']) && $details['image'])
                                <img src="{{ Storage::url($details['image']) }}" alt="{{ $details['name'] }}" class="h-16 w-16 rounded object-contain bg-gray-50 p-1 border border-gray-100">
                            @else
                                <div class="h-16 w-16 rounded bg-mocha-accent/10 border border-mocha-accent/30 flex items-center justify-center"><span class="text-mocha-accent/50 text-[10px]">IMG</span></div>
                            @endif
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between text-sm font-medium text-mocha-text mb-1">
                                    <h3 class="line-clamp-1 pr-4">{{ $details['name'] }}</h3>
                                    <p>${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                </div>
                                    <p class="text-xs text-mocha-accent">Qty: {{ $details['quantity'] }} x ${{ number_format($details['price'], 2) }}
                                        @if(isset($details['retail_price']) && $details['retail_price'] > $details['price'])
                                            <span class="text-gray-400 line-through ml-1">${{ number_format($details['retail_price'], 2) }}</span>
                                        @endif
                                    </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <div class="flow-root border-t border-gray-100 pt-4">
                    <dl class="-my-4 text-sm divide-y divide-gray-100">
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-gray-600">Subtotal</dt>
                            <dd class="font-medium text-mocha-text">${{ number_format($total, 2) }}</dd>
                        </div>
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-gray-600">Taxes & Shipping</dt>
                            <dd class="font-medium text-green-600">Free</dd>
                        </div>
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-base font-bold text-mocha-text">Order Total</dt>
                            <dd class="text-xl font-bold text-mocha-accent">${{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
