import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'

import toc from './scripts/toc'
import epub from './scripts/epub'
import comic from './scripts/comic'

import Alpine from 'alpinejs'
import webreader from './scripts/webreader'

window.Alpine = Alpine

Alpine.data('toc', toc)
Alpine.data('epub', epub)
Alpine.data('comic', comic)
Alpine.store('webreader', webreader)

Alpine.start()
