import typescriptable from '@kiwilan/typescriptable-laravel/vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import AutoImport from 'unplugin-auto-import/vite'
import svgTransformer from 'unplugin-svg-transformer/vite'
import Components from 'unplugin-vue-components/vite'
import { defineConfig } from 'vite'

export default defineConfig({
  // build: {
  //   ssr: true,
  // },
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
    Components({
      directoryAsNamespace: true,
      dirs: [
        'resources/js/Components',
        'resources/js/Layouts',
      ],
    }),
    AutoImport({
      exclude: [
        /resources\/js\/Composables\.ts/,
      ],
      imports: [
        'vue',
      ],
    }),
  ],
  optimizeDeps: {
    include: [
      'vue',
      '@inertiajs/vue3',
      '@vueuse/core',
    ],
  },
})
