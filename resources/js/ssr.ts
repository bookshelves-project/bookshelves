import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { resolvePages, resolveTitle, VueTypescriptable } from '@kiwilan/typescriptable-laravel'
import { renderToString } from '@vue/server-renderer'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import { createSSRApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import './icons'

createServer(page =>
  createInertiaApp({
    title: title => resolveTitle(title, 'Bookshelves'),
    page,
    render: renderToString,
    resolve: name => resolvePages(name, import.meta.glob('./Pages/**/*.vue')),
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) })
        .use(plugin)
        .use(VueTypescriptable)
        .use(SvgTransformerPlugin)
        .use(ZiggyVue, {
          ...(page.props.ziggy as any),
          location: new URL((page.props.ziggy as any).location),
        })
    },
  }), import.meta.env.VITE_SSR_PORT ?? 13714)
