import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { VueTypescriptable } from '@kiwilan/typescriptable-laravel'
import { SvgTransformerPlugin } from 'unplugin-svg-transformer/vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import './routes'
import './icons'

createServer(page =>
  createInertiaApp({
    page,
    render: renderToString,
    title: title => title,
    resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ App, props, plugin }) {
      return createSSRApp({ render: () => h(App, props) })
        .use(plugin)
        .use(VueTypescriptable)
        .use(SvgTransformerPlugin)
        .use(ZiggyVue, {
          ...page.props.ziggy,
          location: new URL(page.props.ziggy.location),
        })
    },
  }),
)
