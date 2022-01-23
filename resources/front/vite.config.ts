import { defineConfig, Plugin } from 'vite'
import baseConfig from '../vite.config'
import windicss from 'vite-plugin-windicss'

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
  ...baseConfig('front'),
  cacheDir: '../../node_modules/.vite/front',
  resolve: {
    alias: {
      '@front': __dirname,
    },
  },
  plugins: [
    laravel(),
    windicss({
      config: '../../windi.config.ts',
      scan: {
        dirs: ['.'],
        fileExtensions: ['blade.php', 'vue', 'ts'],
      },
    }),
  ],
  optimizeDeps: {
    include: [
      'clockwork-browser/metrics',
      'clockwork-browser/toolbar',
      'vue',
      'alpinejs',
    ],
  },
})
