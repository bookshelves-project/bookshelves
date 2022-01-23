import { defineConfig, Plugin } from 'vite'
import baseConfig from '../vite.config'

/**
 * Enable full reload for blade file
 */
const laravel = (): Plugin => ({
  name: 'vite:laravel',
  handleHotUpdate({ file, server }) {
    if (file.endsWith('.blade.php')) {
      server.ws.send({
        type: 'full-reload',
        path: '*',
      })
    }
  },
})

// https://vitejs.dev/config/
export default defineConfig({
  ...baseConfig('features'),
  cacheDir: '../../node_modules/.vite/features',
  resolve: {
    alias: {
      '@features': __dirname,
    },
  },
  plugins: [
    laravel(),
    // windicss({
    //   config: '../../windi.config.ts',
    //   scan: {
    //     dirs: ['.', '../views'],
    //     fileExtensions: ['blade.php', 'vue', 'ts'],
    //   },
    // }),
  ],
  optimizeDeps: {
    include: [
      'clockwork-browser/metrics',
      'clockwork-browser/toolbar',
      'alpinejs',
      'swiper',
      'axios',
      'date-fns',
      // 'imask',
    ],
  },
})
