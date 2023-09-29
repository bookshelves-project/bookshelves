import antfu from '@antfu/eslint-config'

// https://github.com/antfu/eslint-config
export default antfu({
  ignores: [
    'node_modules/*',
    'public/build/*',
    'public/dist/*',
    'public/vendor/*',
    'public/js/filament/*',
    'vendor/*',
    '*.svg',
    '*.html',
    'bootstrap/ssr/*',
    'resources/webreader/.old/*',
    '.github/*',
  ],
  rules: {
    'no-console': 'warn',
  },
})
