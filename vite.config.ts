import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/admin/filament.css',
        /** Front */
        'resources/front/css/app.css',
        'resources/front/ts/app.ts',
        /** Catalog */
        'resources/catalog/css/app.css',
        'resources/catalog/ts/app.ts',
        /** Webreader */
        'resources/webreader/css/app.css',
        'resources/webreader/ts/app.ts',
      ],
      refresh: ['resources/**'],
      buildDirectory: 'vendor/build',
    }),
  ],
  optimizeDeps: {
    include: ['alpinejs'],
  },
})
