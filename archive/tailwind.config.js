// const svgToDataUri = require('mini-svg-data-uri')
// const plugin = require('tailwindcss/plugin')

module.exports = {
  mode: 'jit',
  content: [
    './app/**/*.php',
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
        '.word-wraping': {
          'text-align': 'justify',
          '-webkit-hyphens': 'auto',
          '-moz-hyphens': 'auto',
          '-ms-hyphens': 'auto',
          hyphens: 'auto',
        },
      })
    }),
  ],
}
