import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import typescriptable from '@kiwilan/typescriptable-laravel/vite'
import components from 'unplugin-vue-components/vite'
import autoImport from 'unplugin-auto-import/vite'
import svgTransformer from 'unplugin-svg-transformer/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.ts',
        // 'resources/webreader/css/app.css',
        // 'resources/webreader/ts/app.ts',
      ],
      // refresh: [
      //   ...refreshPaths,
      //   'app/Http/Livewire/**',
      // ],
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
    typescriptable({
      routes: true,
      settings: true,
    }),
    components({
      dts: true,
      directoryAsNamespace: true,
      dirs: ['resources/js/Components', 'resources/js/Composables', 'resources/js/Layouts'],
    }),
    autoImport({
      dts: true,
      dirs: ['resources/js/Components', 'resources/js/Composables', 'resources/js/Layouts'],
      imports: ['vue'],
    }),
    svgTransformer({
      svgDir: './resources/svg',
      libraryDir: './resources/js',
      global: true,
      svg: {
        currentColor: true,
        sizeInherit: true,
        clearSize: 'all',
      },
    }),
  ],
})
