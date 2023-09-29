import antfu from '@antfu/eslint-config'

// https://github.com/antfu/eslint-config
export default antfu({
  ignores: [
    'node_modules/*',
    'public/build/*',
    'public/dist/*',
    'vendor/*',
    '*.svg',
    '*.html',
    'bootstrap/ssr/*',
  ],
  rules: {
    'no-console': 'warn',
  },
})
