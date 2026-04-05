<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-mocha-text antialiased bg-mocha-light">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side: Aesthetic Desktop Graphic (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1569529465841-fefe78a9533b?q=80&w=2070');">
                <div class="absolute inset-0 bg-gradient-to-t from-[#1C1107]/90 via-[#1C1107]/40 to-transparent flex flex-col justify-end p-16">
                    <h2 class="font-serif text-5xl text-white font-bold mb-4 leading-tight">Uncompromising Quality,<br>Exceptional Taste.</h2>
                    <p class="text-gray-200 text-lg max-w-md">Discover our curated collection of fine wines and craft spirits. Experience luxury with every pour. Drink responsibly.</p>
                </div>
            </div>

            <!-- Right Side: Auth Form centering section -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-mocha-light min-h-screen">
                <div class="w-full max-w-md">
                    <!-- Top Logo Header -->
                    <div class="text-center mb-8">
                        <a href="/" class="font-serif text-4xl font-bold text-mocha-accent">Elm Grove</a>
                        <p class="text-[10px] sm:text-xs tracking-widest text-gray-500 uppercase mt-1">LIQUOR</p>
                    </div>

                    <!-- Outer Card Frame -->
                    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
