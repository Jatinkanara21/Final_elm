@extends('layouts.main')

@section('title', $product->name)

@section('content')
<div class="bg-white/80 py-4 border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-mocha-accent transition-colors">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        <a href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}" class="hover:text-mocha-accent transition-colors">{{ $product->category->name ?? 'Category' }}</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        <span class="text-gray-700 line-clamp-1 font-medium">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Product Details Detail -->
    <div class="glassmorphism rounded-2xl overflow-hidden border border-white/10 p-6 md:p-12 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <!-- Product Image -->
            <div class="flex justify-center items-center bg-gray-50 rounded-xl p-8 min-h-[400px] border border-gray-100">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="max-h-96 object-contain drop-shadow-md">
                @else
                    <div class="w-32 h-64 bg-mocha-accent/10 rounded-t-full rounded-b-lg border-2 border-mocha-accent/30 flex items-center justify-center">
                        <span class="text-mocha-accent/50 text-sm font-serif rotate-90">{{ $product->category->name ?? 'BOTTLE' }}</span>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-center">
                @if($product->brand)
                    <p class="text-mocha-accent font-bold tracking-widest uppercase text-sm mb-2">{{ $product->brand }}</p>
                @endif
                <h1 class="text-3xl sm:text-4xl font-serif font-bold text-mocha-text mb-4">{{ $product->name }}</h1>
                
                <!-- Rating Summary -->
                @php
                    $avgRating = $product->reviews->avg('rating') ?: 0;
                    $reviewCount = $product->reviews->count();
                @endphp
                <div class="flex items-center mb-6">
                    <div class="flex text-yellow-500 text-sm">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= $avgRating)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-2 text-sm text-gray-500">({{ $reviewCount }} reviews)</span>
                </div>

                
                <p class="text-gray-600 leading-relaxed mb-8">{{ $product->description }}</p>

                <div class="flex items-center space-x-4 mb-8">
                    
                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-mocha-secondary hover:bg-gray-800 border border-white/20 text-white p-4 rounded-lg transition-colors flex items-center justify-center tooltip" title="Add to Wishlist">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-20 border-t border-gray-100 pt-16">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-serif font-bold text-mocha-text mb-2">Customer Feedback</h2>
                <p class="text-gray-500">What others are saying about {{ $product->name }}</p>
            </div>
            
            <div class="flex items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-50">
                <div class="text-3xl font-bold text-mocha-text mr-4">{{ number_format($avgRating, 1) }}</div>
                <div>
                    <div class="flex text-yellow-500 mb-1">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-xs text-gray-400 uppercase tracking-widest font-bold">Base on {{ $reviewCount }} reviews</div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
            <!-- Review Form -->
            <div class="lg:col-span-1 sticky top-28">
                <div class="glassmorphism p-8 rounded-2xl border border-white/20 shadow-xl bg-white/70">
                    <h3 class="text-xl font-serif font-bold text-mocha-text mb-6">Share your experience</h3>
                    @auth
                        <form action="{{ route('reviews.store') }}" method="POST" x-data="{ rating: 5, hoverRating: 0 }">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="rating" :value="rating">
                            
                            <div class="mb-8">
                                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Your Rating</label>
                                <div class="flex items-center space-x-2">
                                    <template x-for="i in 5">
                                        <button type="button" 
                                            @click="rating = i" 
                                            @mouseenter="hoverRating = i" 
                                            @mouseleave="hoverRating = 0"
                                            class="focus:outline-none transition-transform hover:scale-125"
                                        >
                                            <svg class="w-8 h-8 cursor-pointer transition-colors duration-150" 
                                                :class="(hoverRating || rating) >= i ? 'text-yellow-400 fill-current' : 'text-gray-200 fill-current'" 
                                                viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    </template>
                                    <span class="ml-4 text-sm font-bold text-gray-500" x-text="rating + ' / 5'"></span>
                                </div>
                            </div>

                            <div class="mb-8">
                                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Commentary</label>
                                <textarea name="comment" rows="5" class="w-full bg-white border-gray-200 rounded-xl focus:ring-mocha-accent focus:border-mocha-accent text-gray-800 p-4 shadow-inner" placeholder="Tell us what you liked..." required></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1 active:translate-y-0">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <div class="bg-mocha-accent/5 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-mocha-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                            </div>
                            <h4 class="text-mocha-text font-bold mb-2">Member Sign In</h4>
                            <p class="text-sm text-gray-500 mb-6">Please log in to share your experience with us.</p>
                            <a href="{{ route('login') }}" class="inline-block w-full bg-mocha-accent text-white py-3 rounded-xl font-bold hover:bg-[#A0522D] transition-all">Sign In to Review</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Review List -->
            <div class="lg:col-span-2 space-y-8">
                @forelse($product->reviews->where('is_approved', 1) as $review)
                    <div class="glassmorphism p-8 rounded-2xl border border-white/20 shadow-sm transition-all hover:shadow-md group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-mocha-accent/10 border border-mocha-accent/20 flex items-center justify-center text-mocha-accent font-bold text-lg mr-4">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-mocha-text">{{ $review->user->name }}</h4>
                                    <div class="flex text-yellow-500 text-xs mt-1">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs font-medium text-gray-400 bg-gray-100/50 px-3 py-1 rounded-full">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="pl-16">
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white/50 rounded-2xl border border-dashed border-gray-300">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        <h3 class="text-xl font-medium text-gray-500 italic">No reviews yet.</h3>
                        <p class="text-gray-400 mt-2">Become the first to share your thoughts on this product!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
