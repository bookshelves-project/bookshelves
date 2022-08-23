import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/filament.css',
        'resources/css/app.css',
      ],
      refresh: true,
    }),
  ],
  optimizeDeps: {
    include: ['alpinejs'],
  },
})
