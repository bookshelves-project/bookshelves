import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

import 'virtual:windi.css'
import './app.css'
import './css/markdown.css'

import codeblock from './scripts/components/codeblock'
import toc from './scripts/components/toc'

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.data('codeblock', codeblock)
Alpine.data('toc', toc)

Alpine.start()
