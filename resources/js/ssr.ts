import type { DefineComponent } from 'vue'
import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { VueTypescriptable } from '@kiwilan/typescriptable-laravel'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import './routes'
import './icons'

createServer(page => createInertiaApp({
  page,
  render: renderToString,
  title: title => `${title} · Bookshelves`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, (import.meta as any).glob('./Pages/**/*.vue')) as Promise<DefineComponent>,
  setup({ el, App, props, plugin }) {
    const app = createSSRApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueTypescriptable)
      .use(SvgTransformerPlugin)
      // .use(ZiggyVue, {
      //   ...(page.props.ziggy as any),
      //   location: new URL((page.props.ziggy as any).location),
      // })
      .use(ZiggyVue, {
        ...page.props.ziggy,
        location: new URL(page.props.ziggy.url),
      })

    app.mount(el)
  },
}))
