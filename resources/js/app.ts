import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePages, resolveTitle, VueTypescriptable } from '@kiwilan/typescriptable-laravel'
import NProgress from 'nprogress'
import { createPinia } from 'pinia'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import '../css/app.css'
import './icons'

createInertiaApp({
  title: title => resolveTitle(title, 'Bookshelves'),
  resolve: name => resolvePages(name, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const pinia = createPinia()
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueTypescriptable)
      .use(SvgTransformerPlugin)
      .use(ZiggyVue)
      .use(pinia)
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
