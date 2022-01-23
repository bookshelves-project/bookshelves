import { defineConfig } from 'windicss/helpers'
import defaultTheme from 'windicss/defaultTheme'
import formsPlugin from 'windicss/plugin/forms'
import typographyPlugin from 'windicss/plugin/typography'
import scrollbarPlugin from '@windicss/plugin-scrollbar'
import svgToDataUri from 'mini-svg-data-uri'

const primary = {
  DEFAULT: '#564fcc',
  100: '#e2e0ff',
  200: '#c4c1ff',
  300: '#a7a1ff',
  400: '#8982ff',
  500: '#6c63ff',
  600: '#564fcc',
  700: '#413b99',
  800: '#2b2866',
  900: '#161433',
}

export default defineConfig({
  theme: {
    fontFamily: {
      sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
    },
    extend: {
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
      colors: {
        primary,
      },
      borderColor: {
        primary,
      },
      textColor: {
        primary,
      },
      fontFamily: {
        quicksand: ['Quicksand'],
        handlee: ['Handlee, cursive'],
      },
      backgroundImage: () => ({
        'multiselect-caret': `url("${svgToDataUri(
          `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>`
        )}")`,
        'multiselect-spinner': `url("${svgToDataUri(
          `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>`
        )}")`,
        'multiselect-remove': `url("${svgToDataUri(
          `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>`
        )}")`,
      }),
    },
  },
  plugins: [formsPlugin, typographyPlugin, scrollbarPlugin],
})
