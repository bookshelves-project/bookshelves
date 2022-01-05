const svgToDataUri = require('mini-svg-data-uri')
const plugin = require('tailwindcss/plugin')

const orange = {
  DEFAULT: 'var(--color-orange)',
  50: '#FED0C4',
  100: '#FEC6B7',
  200: '#FDB29E',
  300: '#FD9F85',
  400: '#FC8B6C',
  500: '#FC7753',
  600: '#FC633A',
  700: '#FB4F21',
  800: '#FB3C08',
  900: '#E53404',
}

const yellow = {
  DEFAULT: 'var(--color-yellow)',
  50: '#FFFBF3',
  100: '#FFF7E6',
  200: '#FFEECD',
  300: '#FEE5B4',
  400: '#FEDD9A',
  500: '#FED481',
  600: '#FECB68',
  700: '#FEC34E',
  800: '#FDBA35',
  900: '#FDB11C',
}

const blue = {
  DEFAULT: 'var(--color-blue)',
  50: '#1D98FF',
  100: '#1092FF',
  200: '#0086F5',
  300: '#0078DC',
  400: '#006AC3',
  500: '#0D3082',
  600: '#004E8F',
  700: '#004076',
  800: '#00325C',
  900: '#002443',
}

const primary = { ...orange, DEFAULT: 'var(--color-primary)' }
const secondary = { ...yellow, DEFAULT: 'var(--color-secondary)' }

module.exports = {
  mode: 'jit',
  content: [
    './app/**/*.{php}',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.{blade.php,vue,ts}',
  ],
  darkMode: 'class',
  theme: {
    container: {
      center: true,
    },
    screens: {
      sm: '360px',
      md: '600px',
      lg: '900px',
      xl: '1300px',
      '2xl': '1536px',
      '3xl': '1920px',
    },
    extend: {
      colors: {
        primary: {
          100: '#e2e0ff',
          200: '#c4c1ff',
          300: '#a7a1ff',
          400: '#8982ff',
          500: '#6c63ff',
          600: '#564fcc',
          700: '#413b99',
          800: '#2b2866',
          900: '#161433',
        },
        secondary,
        orange,
        yellow,
        blue,
        gray: {
          light: '#F5F5F5',
          DEFAULT: '#D1D1D1',
          dark: '#3F3F3F',
          darkest: '#191919',
        },
      },
      fontFamily: {
        quicksand: ['Quicksand'],
        handlee: ['Handlee, cursive'],
      },
      // backgroundImage: () => ({
      //   'multiselect-caret': `url("${svgToDataUri(
      //     `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      //       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      //     </svg>`
      //   )}")`,
      //   'multiselect-spinner': `url("${svgToDataUri(
      //     `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      //       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
      //     </svg>`
      //   )}")`,
      //   'multiselect-remove': `url("${svgToDataUri(
      //     `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      //       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      //     </svg>`
      //   )}")`,
      // }),
    },
  },
  plugins: [
    plugin(function ({ addComponents, theme }) {
      addComponents({
        '.main-content': {
          '@apply container !max-w-7xl lg:pt-6 pt-5 min-h-[70vh] text-black dark:text-white':
            {},
        },
        '.internal-link': {
          '@apply text-gray-900 transition-colors duration-100 border-b border-gray-500 dark:border-gray-100 dark:hover:border-gray-400 hover:border-gray-400 dark:text-gray-100 hover:text-gray-400 dark:hover:text-gray-400 !important':
            {},
        },
        '.word-wraping': {
          'text-align': 'justify',
          '-webkit-hyphens': 'auto',
          '-moz-hyphens': 'auto',
          '-ms-hyphens': 'auto',
          hyphens: 'auto',
        },
        '.display-grid': {
          '@apply grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4':
            {},
        },
        '.nuxt-link-active': {
          '@apply text-gray-900 border-primary-500 dark:text-white': {},
        },
      })
    }),
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/line-clamp'),
    require('tailwindcss-debug-screens'),
    require('tailwind-scrollbar'),
  ],
}
