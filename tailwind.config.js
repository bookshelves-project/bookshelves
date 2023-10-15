import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import aspectRatio from '@tailwindcss/aspect-ratio'
import plugin from 'tailwindcss/plugin'
import colors from 'tailwindcss/colors'
import defaultTheme from 'tailwindcss/defaultTheme'

/** @type {import('tailwindcss').Config} */
export default {
  safelist: [
    'w-6', // svg
    'h-6', // svg
  ],
  content: [
    './resources/**/*.{vue,js,ts,jsx,tsx,php}',
    './vendor/filament/**/*.blade.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        quicksand: ['Quicksand'],
        handlee: ['Handlee, cursive'],
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        danger: colors.rose,
        primary: {
          50: '#cfcdff',
          100: '#c4c0ff',
          200: '#b8b4ff',
          300: '#aca7ff',
          400: '#a09bff',
          500: '#948eff',
          600: '#8982ff',
          700: '#7b75e5',
          800: '#6d68cc',
          900: '#5f5bb2',
        },
        success: colors.green,
        warning: colors.yellow,
      },
    },
  },
  plugins: [
    plugin(({ addComponents }) => {
      addComponents({
        '.main-container': {
          '@apply container mx-auto max-w-7xl px-4 md:px-6':
              {},
        },
        '.center': {
          '@apply absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2':
              {},
        },
        '.debug-screens': {
          '@apply before:bottom-0 before:left-0 before:fixed before:px-1 before:text-sm before:bg-black before:text-white before:shadow-xl before:content-["screen:_"] sm:before:content-["screen:sm"] md:before:content-["screen:md"] lg:before:content-["screen:lg"] xl:before:content-["screen:xl"] 2xl:before:content-["screen:2xl"]':
                {},
          '&:before': {
            'z-index': '2147483647',
          },
        },
      })
    }),
    forms,
    typography,
    aspectRatio,
  ],
}
