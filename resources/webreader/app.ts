import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

// import epub from './scripts/alpine/epub'
import Alpine from 'alpinejs'
import type { Alpine as AlpineType } from '@types/alpinejs'
import epubjs from './scripts/alpine/epubjs'
import comic from './scripts/alpine/comic'
import webreader from './scripts/alpine/webreader'
import events from './scripts/alpine/events'

// @ts-expect-error

const alpine: AlpineType = Alpine
window.Alpine = alpine

// alpine.data('epub', epub)
alpine.data('epubjs', epubjs)
alpine.data('comic', comic)
alpine.store('webreader', webreader)
alpine.data('events', events)

alpine.start()
