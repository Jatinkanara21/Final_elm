@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent focus:border-mocha-accent shadow-sm']) }}>
