import './bootstrap'
import '../css/app.css'

import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

import { VueTypescriptable } from '@kiwilan/typescriptable-laravel' // Import VueTypescriptable
import NProgress from 'nprogress'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

import './routes' // Import routes

createInertiaApp({
  title: title => `${title} - Laravel`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')) as Promise<DefineComponent>,
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(VueTypescriptable) // Add Vue plugin

    router.on('start', () => NProgress.start())
    router.on('finish', () => NProgress.done())

    app.mount(el)
  },
  progress: {
    delay: 250,
    color: '#18ba82',
    includeCSS: true,
    showSpinner: false,
  },
})
