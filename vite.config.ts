import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',

        'resources/webreader/css/app.css',
        'resources/webreader/ts/app.ts',

        // https://filamentphp.com/docs/2.x/admin/appearance
        'resources/css/filament.css',
      ],
      refresh: [
        ...refreshPaths,
        'app/Http/Livewire/**',
      ],
    }),
  ],
})
