import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Arimo', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'customBlue': 'rgb(6, 18, 56)', // Define your custom RGB color
                'customglue': '#202A4D',
                'lighterBlue': '#f8fbff',
             
            },
            
            
        },
    },

    plugins: [forms, typography],
};