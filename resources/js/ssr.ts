import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { VueTypescriptable, resolve } from '@kiwilan/typescriptable-laravel'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import './routes'
import './icons'

createServer(page => createInertiaApp({
  page,
  render: renderToString,
  title: title => `${title} · Kiwiflix`,
  resolve: name => resolve(name, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createSSRApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueTypescriptable)
      .use(SvgTransformerPlugin)
      .use(ZiggyVue, {
        ...(page.props.ziggy as any),
        location: new URL((page.props.ziggy as any).location),
      })
      .mount(el)
  },
}))
