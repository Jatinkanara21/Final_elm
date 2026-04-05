import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx', // if using react, not used here
    ],

    theme: {
        extend: {
            colors: {
                accent: '#8B4513',
                secondary: '#1A1A1A',
                darkMocha: '#1C1107',
                mocha: {
                    light: '#FDF5E6',
                    dark: '#1C1107',
                    accent: '#8B4513',
                    secondary: '#1A1A1A',
                    text: '#1A1A1A',
                }
            },
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [forms],
};
