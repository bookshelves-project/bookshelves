import './bootstrap'
import '../css/app.css'

import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { VueTypescriptable } from '@kiwilan/typescriptable-laravel'

// import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import NProgress from 'nprogress'

// eslint-disable-next-line antfu/no-import-dist
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

// import { Tooltip } from './Directives/Tooltip'
// import './icons'
import './routes'

createInertiaApp({
  title: title => `${title} · Kiwiflix`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')) as Promise<DefineComponent>,
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueTypescriptable)
      // .use(SvgTransformerPlugin)
      .use(ZiggyVue)
      // .directive('tooltip', Tooltip)

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
