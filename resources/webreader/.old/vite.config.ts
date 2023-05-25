import type { PluginOption } from 'vite'
import { defineConfig } from 'vite'
import windicss from 'vite-plugin-windicss'
import baseConfig from '../vite.config'

/**
 * Enable full reload for blade file
 */
const laravel = (): PluginOption => ({
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
  ...baseConfig('webreader'),
  cacheDir: '../../node_modules/.vite/webreader',
  resolve: {
    alias: {
      '@webreader': __dirname,
    },
  },
  plugins: [
    laravel(),
    windicss({
      config: '../../windi.config.ts',
      scan: {
        dirs: ['.', '../views', '../components'],
        fileExtensions: ['blade.php', 'vue', 'ts'],
      },
    }),
  ],
  optimizeDeps: {
    include: [
      'vue',
      'alpinejs',
      'epubjs',
      '@comix/parser',
      'jszip',
      'jszip-utils',
    ],
  },
})
