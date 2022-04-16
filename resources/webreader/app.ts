import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

import toc from './scripts/toc'
import epubjs from './scripts/epub'
import cbz from './scripts/cbz'
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
Alpine.data('epubjs', epubjs)
Alpine.data('cbz', cbz)
Alpine.store('sidebar', sidebar)

Alpine.start()
