import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // <-- تفعيل الداكن عن طريق إضافة class="dark" على <html> أو <body>
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                //  تحديث الخطوط الافتراضية هنا
                sans: ['Almarai', 'Cairo', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#3338A0",
                secondary: "#C59560",
                accent: "#FCC61D",
                lightbg: "#F7F7F7",
                darkbg: "#1F1F2F", // <-- إضافة لون خلفية للداكن
                darktext: "#E5E5E5", // <-- لون النص في الداكن
            },
        },
    },

    plugins: [forms],
};
