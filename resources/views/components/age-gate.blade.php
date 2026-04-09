<!-- resources/views/components/age-gate.blade.php -->
<div x-data="{
    showGate: false,
    verifyAge() {
        localStorage.setItem('age_verified', 'true');
        this.showGate = false;
        document.body.classList.remove('overflow-hidden');
    },
    declineAge() {
        window.location.href = 'https://www.google.com';
    },
    init() {
        if (!localStorage.getItem('age_verified')) {
            this.showGate = true;
            document.body.classList.add('overflow-hidden');
        }
    }
}" x-show="showGate" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-mocha-dark/95 backdrop-blur-md"></div>

    <!-- Modal panel -->
    <div x-show="showGate"
         x-transition:enter="ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="relative w-full max-w-sm mx-4 text-center">

        <!-- Decorative top line -->
        <div class="mx-auto w-16 h-px bg-mocha-accent mb-8"></div>

        <!-- Icon -->
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full border border-mocha-accent/30 bg-mocha-accent/10">
            <!-- Wine glass icon -->
            <svg class="h-9 w-9 text-mocha-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 2h8l-1.5 7A4.5 4.5 0 0 1 12 13.5 4.5 4.5 0 0 1 7.5 9L6 2z"/>
                <line x1="12" y1="13.5" x2="12" y2="20"/>
                <line x1="8.5" y1="20" x2="15.5" y2="20"/>
            </svg>
        </div>

        <!-- Heading -->
        <h3 class="font-serif text-3xl font-bold text-white tracking-wide mb-3">
            Age Verification
        </h3>

        <!-- Divider -->
        <div class="flex items-center justify-center gap-3 mb-5">
            <div class="h-px w-8 bg-mocha-accent/40"></div>
            <div class="h-1 w-1 rounded-full bg-mocha-accent/60"></div>
            <div class="h-px w-8 bg-mocha-accent/40"></div>
        </div>

        <!-- Description -->
        <p class="text-gray-400 text-sm leading-relaxed mb-10 px-4">
            You must be of legal drinking age (21+) to enter this site.<br>
            By continuing, you confirm you are at least 21 years old.
        </p>

        <!-- Buttons -->
        <div class="flex flex-col gap-3 sm:flex-row sm:gap-4">
            <button @click="verifyAge()"
                class="flex-1 bg-mocha-accent hover:bg-[#A0522D] text-white font-semibold py-3.5 px-6 rounded transition-all duration-200 hover:shadow-[0_0_20px_rgba(139,69,19,0.4)] tracking-wide text-sm uppercase">
                Yes, I am 21+
            </button>
            <button @click="declineAge()"
                class="flex-1 border border-white/10 hover:border-white/20 text-gray-400 hover:text-gray-200 font-medium py-3.5 px-6 rounded transition-all duration-200 tracking-wide text-sm uppercase">
                Under 21
            </button>
        </div>

        <!-- Footer note -->
        <p class="mt-8 text-xs text-gray-600 tracking-widest uppercase">
            Please drink responsibly
        </p>

        <!-- Decorative bottom line -->
        <div class="mx-auto w-16 h-px bg-mocha-accent mt-8"></div>
    </div>
</div>
