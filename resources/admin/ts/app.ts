import Alpine from 'alpinejs'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import EditorAlpinePlugin from './editor'
import NotificationsAlpinePlugin from '@/vendor/filament/notifications/dist/module.esm'

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)
// Alpine.plugin(EditorAlpinePlugin)

window.Alpine = Alpine

Alpine.data('editor', EditorAlpinePlugin)

Alpine.start()
