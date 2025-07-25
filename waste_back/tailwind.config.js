import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors'
const primary = {
    '50': '#f6f5f5',
    '100': '#e7e6e6',
    '200': '#d1d0d0',
    '300': '#b2aeaf',
    '400': '#8a8688',
    '500': '#676364',
    '600': '#5f5b5c',
    '700': '#504e4f',
    '800': '#464445',
    '900': '#3d3c3c',
    '950': '#272525',
};
const secondary = colors.pink
const info = colors.sky
const warning = colors.amber
const success = colors.emerald
const error = colors.red

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['roboto', 'Verdana', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary,
                secondary,
                info,
                warning,
                success,
                error,
                blueBg: "#E9EEF6",
            },
            backgroundImage: {
                'sotial-fb': "url('/storage/sotial (1).png')",
                'sotial-fb1': "url('/storage/sotial (6).png')",
                'sotial-gl': "url('/storage/sotial (2).png')",
                'sotial-gl1': "url('/storage/sotial (3).png')",
                'sotial-tw': "url('/storage/sotial (5).png')",
                'sotial-tw1': "url('/storage/sotial (4).png')",
            }
        },
    },

    plugins: [forms],
};
