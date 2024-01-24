import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import plugin from 'tailwindcss/plugin'

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
      screens: {
        'sm': '500px', // 640px
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
      },
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      aspectRatio: {
        poster: '2 / 3',
        album: '1 / 1',
      },
    },
  },

  plugins: [
    plugin(({ addComponents }) => {
      addComponents({
        '.poster': {
          '@apply aspect-poster rounded-md object-cover': {},
        },
        '.album': {
          '@apply aspect-album rounded-md object-cover': {},
        },
        '.video-list': {
          '@apply grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6':
              {},
        },
        '.main-container': {
          '@apply container mx-auto max-w-7xl px-4 lg:px-8':
                {},
        },
        '.link': {
          '@apply underline decoration-dashed hover:text-gray-200 hover:decoration-gray-200': {},
        },
        '.hover-zoom': {
          '@apply transition-transform duration-300 ease-in-out hover:scale-[1.03]': {},
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
  ],
}
