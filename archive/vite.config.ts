import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { PluginOption } from 'vite'

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

export default ({ command }) =>
  defineConfig({
    // export default ({ command }) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: 'fake_dir_so_nothing_gets_copied',
    server: {
      port: 3001,
    },
    build: {
      manifest: true,
      outDir: 'public/build',
      rollupOptions: {
        input: 'resources/js/app.ts',
      },
    },
    // base: command === 'serve' ? '' : '/build/',
    // outDir: 'public/build',
    // publicDir: 'fake_dir_so_nothing_gets_copied',
    // build: {
    //   manifest: true,
    //   rollupOptions: {
    //     input: 'resources/js/app.js',
    //   },
    // },
    plugins: [vue(), laravel()],
  })
