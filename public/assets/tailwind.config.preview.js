import plugin from 'tailwindcss/plugin'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/preview/index.blade.php',
  ],
  plugins: [
    plugin(({ addComponents }) => {
      addComponents({
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
  ],
}
