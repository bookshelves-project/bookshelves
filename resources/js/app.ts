import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { VueTypescriptable, resolve } from '@kiwilan/typescriptable-laravel'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import NProgress from 'nprogress'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import './icons'
import './routes'

createInertiaApp({
  title: title => `${title} · Bookshelves`,
  resolve: name => resolve(name, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueTypescriptable)
      .use(SvgTransformerPlugin)
      .use(ZiggyVue)

    router.on('start', () => NProgress.start())
    router.on('finish', () => NProgress.done())

    app.mount(el)

    const root = document.documentElement
    root.classList.add('dark')
  },
  progress: {
    delay: 250,
    color: '#a855f7',
    includeCSS: true,
    showSpinner: false,
  },
})
