import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import typescriptable from '@kiwilan/typescriptable-laravel/vite'
import svgTransformer from 'unplugin-svg-transformer/vite'
import Components from 'unplugin-vue-components/vite'
import AutoImport from 'unplugin-auto-import/vite'

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
