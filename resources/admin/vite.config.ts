import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import components from 'unplugin-vue-components/vite'
import baseConfig from '../vite.config'
import windicss from 'vite-plugin-windicss'

// https://vitejs.dev/config/
export default defineConfig({
  ...baseConfig('admin'),
  cacheDir: '../../node_modules/.vite/admin',
  resolve: {
    alias: {
      '@admin': __dirname,
    },
  },
  plugins: [
    vue(),
    components({
      dirs: ['base', 'components', 'layouts'],
      dts: true,
    }),
    windicss({
      config: '../../windi.config.ts',
      scan: {
        dirs: ['.'],
        fileExtensions: ['blade.php', 'vue', 'ts'],
      },
    }),
  ],
  optimizeDeps: {
    entries: ['admin/app.ts'],
    include: [
      'clockwork-browser/metrics',
      'clockwork-browser/toolbar',
      'vue',
      'axios',
      '@inertiajs/inertia',
      '@inertiajs/inertia-vue3',
      '@inertiajs/progress',
      '@headlessui/vue',
      'ziggy-js',
      'matice',
      'date-fns',
      'qs',
      'vuedraggable',
      'lodash/pick',
      'lodash/trimEnd',
      'lodash/trimStart',
      'lodash/truncate',
      'lodash/get',
      'lodash/set',
      'lodash/truncate',
      'lodash/last',
      'lodash/isEmpty',
      '@vueuse/core',
      '@vueuse/shared',
      '@heroicons/vue/solid',
      '@heroicons/vue/outline',
      '@tinymce/tinymce-vue',
      'flatpickr',
      'flatpickr/dist/l10n/fr.js',
      '@vueform/multiselect',
    ],
  },
})
