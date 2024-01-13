import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import typescriptable from '@kiwilan/typescriptable-laravel/vite'
import svgTransformer from 'unplugin-svg-transformer/vite'

export default defineConfig({
  resolve: {
    alias: {
      '@': '/resources/js',
      '~': '/',
    },
  },
  plugins: [
    laravel({
      input: 'resources/js/app.ts',
      ssr: 'resources/js/ssr.ts',
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
    typescriptable(),
    svgTransformer({
      svg: {
        sizeInherit: true,
      },
      svgDir: 'resources/svg',
      libraryDir: 'resources/js',
      global: true,
    }),
  ],
})
