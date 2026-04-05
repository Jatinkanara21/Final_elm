<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-mocha-accent border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-[#A0522D] active:bg-[#8B4513] focus:outline-none focus:ring-2 focus:ring-mocha-accent focus:ring-offset-2 focus:ring-offset-mocha-dark transition ease-in-out duration-150 shadow-lg']) }}>
    {{ $slot }}
</button>
