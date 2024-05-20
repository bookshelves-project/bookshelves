import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import { VueTypescriptable, resolve } from '@kiwilan/typescriptable-laravel'
import NProgress from 'nprogress'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import './routes'
import './icons'

createInertiaApp({
  title: title => `${title} · Kiwiflix`,
  resolve: name => resolve(name, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueTypescriptable)
      .use(SvgTransformerPlugin)
      .use(ZiggyVue)
      .mount(el)

    router.on('start', () => NProgress.start())
    router.on('finish', () => NProgress.done())

    document.documentElement.classList.add('dark')
  },
  progress: {
    delay: 250,
    color: '#a855f7',
    includeCSS: true,
    showSpinner: false,
  },
})
