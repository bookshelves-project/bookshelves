import Alpine from 'alpinejs'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
// import { editorData } from './editor'
import { EditorAlpinePlugin } from '@kiwilan/vite-plugin-laravel-steward'
import NotificationsAlpinePlugin from '@/vendor/filament/notifications/dist/module.esm'

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.plugin(EditorAlpinePlugin)

window.Alpine = Alpine

// Alpine.data('editor', editorData)

Alpine.start()
