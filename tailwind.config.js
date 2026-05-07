import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                cream: '#fdfdfc',
                'brown-light': '#f6f1eb',
                'brown-main': '#7a4b2b',
                'brown-dark': '#4b2e1e',
                'pink-soft': '#fff2f2',
            }
        },
    },

    plugins: [forms],
};
