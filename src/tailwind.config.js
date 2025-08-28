import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
                sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                xs: '0.75rem',
                sm: 'clamp(10px, calc(10.00px + 0px), 10px)',
                md: 'clamp(14px, calc(14.00px + 0.00vw), 14px)',
                lg: 'clamp(18px, calc(3.71px + 3.81vw), 22px)'
            },
            screens: {
                sm: '640px',
                md: '768px',
                lg: '1024px',
            },
            colors: {
                white: {
                    100: '#fff',
                    600: '#f2f2f2',
                    700: '#e6e6e6',
                    800: '#d9d9d9',
                    900: '#ccc',
                },
                black: {
                    100: '#333',
                    200: '#262626',
                    300: '#1a1a1a',
                    400: '#0d0d0d',
                    900: '#000',
                },
                gray: {
                    100: '#EDF2F7',
                    200: '#E2E8F0',
                    300: '#CBD5E0',
                    400: '#A0AEC0',
                    500: '#718096',
                    600: '#4A5568',
                    700: '#2D3748',
                    800: '#1A202C',
                    900: '#171923',
                },
                whiteAlpha: {
                    50:  'rgba(255, 255, 255, 0.04)',
                    100: 'rgba(255, 255, 255, 0.06)',
                    200: 'rgba(255, 255, 255, 0.08)',
                    300: 'rgba(255, 255, 255, 0.16)',
                    400: 'rgba(255, 255, 255, 0.24)',
                    500: 'rgba(255, 255, 255, 0.36)',
                    600: 'rgba(255, 255, 255, 0.48)',
                    700: 'rgba(255, 255, 255, 0.64)',
                    800: 'rgba(255, 255, 255, 0.80)',
                    900: 'rgba(255, 255, 255, 0.92)',
                }
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-in-out',
                'slide-up': 'slideUp 0.8s ease-out',
                'bounce-slow': 'bounce 2s infinite',
            },
            backdropBlur: {
                xs: '2px',
            }
        },
    },

    plugins: [
        forms,
    ],
};
