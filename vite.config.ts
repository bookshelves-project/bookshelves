import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/admin/filament.css',
        /** Front */
        'resources/front/css/app.css',
        /** Catalog */
        'resources/catalog/css/app.css',
        /** Webreader */
        'resources/webreader/css/app.css',
      ],
      refresh: ['resources/**'],
    }),
  ],
  optimizeDeps: {
    include: ['alpinejs'],
  },
})
