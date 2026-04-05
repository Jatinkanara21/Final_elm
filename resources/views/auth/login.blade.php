<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-200 bg-white text-mocha-accent shadow-sm focus:ring-mocha-accent" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-mocha-accent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mocha-accent focus:ring-offset-white" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Divider -->
        <div class="relative flex items-center justify-center my-6">
            <div class="border-t border-gray-100 w-full"></div>
            <div class="absolute bg-white px-3 text-xs text-gray-400">OR</div>
        </div>

        <!-- Google Login -->
        <a href="{{ route('auth.google') }}" class="w-full flex justify-center items-center bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-medium py-3 px-4 rounded-xl shadow-sm transition-all group">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" alt="Google">
            Sign in with Google
        </a>
    </form>
</x-guest-layout>
