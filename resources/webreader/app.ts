import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

import toc from './scripts/components/toc'
import epubjs from './scripts/components/epub'

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
Alpine.data('epubjs', epubjs)

Alpine.start()
