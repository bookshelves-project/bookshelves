import antfu from '@antfu/eslint-config'

// https://github.com/antfu/eslint-config
// export default antfu({
//   ignores: [
//     'node_modules/*',
//     'public/build/*',
//     'public/dist/*',
//     'public/vendor/*',
//     'public/js/filament/*',
//     'vendor/*',
//     '*.svg',
//     '*.html',
//     'bootstrap/ssr/*',
//     'resources/webreader/.old/*',
//     '.github/*',
//   ],
export default antfu({
  ignores: [
    '.github/*',
    '.vscode/*',
    'public/build/*',
    'public/vendor/*',
    'public/js/filament/*',
    'resources/**/*.d.ts',
    'storage/*',
    'vendor/*',
  ],
}, {
  rules: {
    'no-console': 'warn',
    'node/prefer-global/process': 'off',
    'vue/max-attributes-per-line': ['error', {
      singleline: 1,
    }],
  },
})
