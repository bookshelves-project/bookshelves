import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

import epub from './scripts/alpine/epub'
import comic from './scripts/alpine/comic'
import webreader from './scripts/alpine/webreader'
import events from './scripts/alpine/events'

import Alpine from 'alpinejs'
// @ts-ignore
import type { Alpine as AlpineType } from '@types/alpinejs'

const alpine: AlpineType = Alpine
window.Alpine = alpine

alpine.data('epub', epub)
alpine.data('comic', comic)
alpine.store('webreader', webreader)
alpine.data('events', events)

alpine.start()
