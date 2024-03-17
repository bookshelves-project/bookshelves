import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { VueTypescriptable } from '@kiwilan/typescriptable-laravel'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import './icons'
import './routes'

createInertiaApp({
  title: title => title,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')) as any,
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueTypescriptable)
      .use(SvgTransformerPlugin)
      .use(ZiggyVue)

    const root = document.documentElement
    root.classList.add('dark')

    app.mount(el)

    return app
  },
  progress: {
    color: '#4B5563',
  },
})
