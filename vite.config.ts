import fs from 'fs'
import type { Plugin } from 'vite'
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

// const colorMode = (): PluginContainer => ({
//   name: 'color-mode',
//   handleHotUpdate({ file, server }) {
//     if (file.endsWith('.blade.php')) {
//       server.ws.send({
//         type: 'full-reload',
//         path: '*',
//       })
//     }
//   },
// })

const colorMode = (): Plugin => {
  return {
    name: 'vite-color-mode',
    buildStart() {
      console.log('start')
      const pathColorMode = 'vendor/kiwilan/laravel-steward/resources/js/color-mode.js'
      const path = process.cwd()
      const fullPath = `${path}/${pathColorMode}`
      const buffer = fs.readFileSync(fullPath)
      fs.copyFile(fullPath, './public/vendor/js/color-mode.js', (err) => {
        if (err)
          throw err
        console.log('source.txt was copied to destination.txt')
      })
      console.log(buffer.toString())
      // const opts: Options = Object.assign({}, DEFAULT_OPTIONS, userOptions)
      // ParseEngine.parse(opts)
    },
    handleHotUpdate({ file, server }) {
      // if (file.endsWith('.md'))
      //   server.restart()
    },
  }
}

// const colorMode = () => {
//   return {
//     name: 'color-mode',

//     transform(src, id) {
//       console.log(src, id)
//       // if (fileRegex.test(id)) {
//       //   return {
//       //     code: compileFileToJS(src),
//       //     map: null // provide source map if available
//       //   }
//       // }
//     },
//   }
// }

export default defineConfig({
  plugins: [
    colorMode(),
    laravel({
      input: [
        /** Admin */
        'resources/admin/filament.css',
        'resources/admin/css/app.css',
        'resources/admin/ts/app.ts',
        /** Front */
        'resources/front/css/app.css',
        'resources/front/ts/app.ts',
        /** Catalog */
        'resources/catalog/css/app.css',
        'resources/catalog/ts/app.ts',
        /** Webreader */
        'resources/webreader/css/app.css',
        'resources/webreader/ts/app.ts',
      ],
      refresh: ['resources/**'],
      buildDirectory: 'vendor/build',
    }),
  ],
  optimizeDeps: {
    include: ['alpinejs'],
  },
})
