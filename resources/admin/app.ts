import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

import { createApp, h } from 'vue'
import { Link, createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

import { createPinia } from 'pinia'
import Route from './plugins/route'
import Translations from './plugins/translations'
import GlobalComponents from './plugins/global-components'
import DateFns from './plugins/date-fns'
import HeroIcons from './plugins/hero-icons'

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.globEager('./pages/**/*')

    return pages[`./pages/${name}.vue`].default
  },
  setup({ el, app, props, plugin }) {
    createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(Route)
      .use(Translations)
      .use(GlobalComponents)
      .use(DateFns)
      .use(HeroIcons)
      .use(createPinia())
      .component('InertiaLink', Link)
      .mount(el)
  },
})

InertiaProgress.init({ color: '#564fcc' })
