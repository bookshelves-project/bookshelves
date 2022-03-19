import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

import codeblock from './scripts/components/codeblock'
import toc from './scripts/components/toc'
import epubjs from './scripts/components/epub'

import Alpine from 'alpinejs'
import { initial } from 'lodash'

window.Alpine = Alpine

Alpine.store('darkMode', {
  on: false,

  toggle() {
    this.on = !this.on
  },
})
Alpine.data('toc', toc)
Alpine.data('epubjs', epubjs)
Alpine.data('dropdown', () => ({
  open: false,

  toggle() {
    this.open = !this.open
  },
}))

Alpine.start()
