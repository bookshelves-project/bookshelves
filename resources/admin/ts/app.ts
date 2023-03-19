import Alpine from 'alpinejs'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import { EditorAlpinePlugin } from '@kiwilan/vite-plugin-laravel-steward'
import NotificationsAlpinePlugin from '@/vendor/filament/notifications/dist/module.esm'
import '@kiwilan/vite-plugin-laravel-steward/css/tiptap.css'

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.plugin(EditorAlpinePlugin)

window.Alpine = Alpine

Alpine.start()
