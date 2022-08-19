import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

// import epub from './scripts/alpine/epub'
import Alpine from 'alpinejs'
import epubjs from './scripts/alpine/epubjs'
import comic from './scripts/alpine/comic'
import webreader from './scripts/alpine/webreader'
import events from './scripts/alpine/events'

window.Alpine = Alpine

// Alpine.data('epub', epub)
Alpine.data('epubjs', epubjs)
Alpine.data('comic', comic)
Alpine.store('webreader', webreader)
Alpine.data('events', events)

Alpine.start()
