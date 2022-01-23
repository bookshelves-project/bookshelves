import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

// import 'virtual:windi.css'
import './app.css'
import '../css/fonts.css'
import '../css/markdown.css'

import codeblock from './scripts/components/codeblock'
import toc from './scripts/components/toc'

import Alpine from 'alpinejs'

window.Alpine = Alpine

const jsonSettings = document.querySelector('[data-json-settings]')
window.settings = jsonSettings ? JSON.parse(jsonSettings.textContent!) : {}

Alpine.store('sidebar', {
  toggled: false,
  overlay: false,
  sidebar: false,

  toggle() {
    if (this.toggled) {
      this.close()
    } else {
      this.open()
    }
  },
  open() {
    this.toggled = !this.toggled
    setTimeout(() => {
      this.overlay = !this.overlay
      this.sidebar = !this.sidebar
    }, 250)
  },
  close() {
    this.overlay = false
    this.sidebar = false
    setTimeout(() => {
      this.toggled = false
    }, 250)
  },
})

Alpine.data('dropdown', () => ({
  open: false,

  toggle() {
    this.open = !this.open
  },
}))

Alpine.data('tocStatic', () => ({
  tocContent: '',

  init() {
    const html = document.getElementsByClassName('table-of-contents')
    const toc = html.item(0)
    toc?.classList.add('hidden')
    this.tocContent = toc?.innerHTML as string
  },

  // toggle() {
  //   this.open = !this.open
  // },
}))

Alpine.data('codeblock', codeblock)
Alpine.data('toc', toc)

Alpine.start()
