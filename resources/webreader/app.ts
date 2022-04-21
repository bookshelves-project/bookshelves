import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

import toc from './scripts/toc'
import epub from './scripts/epub'
import comic from './scripts/comic'
import sidebar from './scripts/sidebar'

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.store('darkMode', {
  on: false,

  toggle() {
    this.on = !this.on
  },
})
Alpine.store('navigation', {
  on: false,

  toggle() {
    this.on = !this.on
  },
})
Alpine.data('toc', toc)
Alpine.data('epub', epub)
Alpine.data('comic', comic)
Alpine.store('sidebar', sidebar)

Alpine.start()
