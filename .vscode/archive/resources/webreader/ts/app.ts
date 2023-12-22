import Alpine from 'alpinejs'

// import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
// import { EditorAlpinePlugin } from '@kiwilan/vite-plugin-laravel-steward'
// import NotificationsAlpinePlugin from '@/vendor/filament/notifications/dist/module.esm'
// import '@kiwilan/vite-plugin-laravel-steward/css/tiptap.css'
import epub from './modules/epub'

// Alpine.plugin(AlpineFloatingUI)
// Alpine.plugin(NotificationsAlpinePlugin)
// Alpine.plugin(EditorAlpinePlugin)

Alpine.data('epub', epub)

window.Alpine = Alpine

Alpine.start()
