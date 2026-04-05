<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-red-600/20 border border-red-500 rounded-md font-semibold text-xs text-red-400 uppercase tracking-widest hover:bg-red-600 hover:text-white active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-mocha-dark transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
