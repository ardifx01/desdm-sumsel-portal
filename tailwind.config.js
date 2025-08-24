import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        {
            // Regex ini sekarang berisi SEMUA 16 warna dari palet di helper
            pattern: /^(bg|text)-(red|blue|green|indigo|purple|orange|pink|teal|cyan|lime|amber|sky|violet|fuchsia|rose|gray)-(100|800)$/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};