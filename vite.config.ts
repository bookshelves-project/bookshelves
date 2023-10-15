import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',

        'resources/webreader/css/app.css',
        'resources/webreader/ts/app.ts',
      ],
      // refresh: [
      //   ...refreshPaths,
      //   'app/Http/Livewire/**',
      // ],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
})
