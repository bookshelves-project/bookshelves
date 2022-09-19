import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import { steward } from './vendor/kiwilan/laravel-steward/dist/steward.cjs'

export default defineConfig({
  plugins: [
    steward(),
    laravel({
      input: [
        /** Admin */
        'resources/admin/filament.css',
        'resources/admin/css/app.css',
        'resources/admin/ts/app.ts',
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
      refresh: [
        ...refreshPaths,
        'resources/**',
        'app/Http/Livewire/**',
      ],
      buildDirectory: 'vendor/build',
    }),
  ],
  optimizeDeps: {
    include: ['alpinejs'],
  },
})
