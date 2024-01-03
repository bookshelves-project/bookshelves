import antfu from '@antfu/eslint-config'

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
