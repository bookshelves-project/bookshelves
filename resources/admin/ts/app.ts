import Alpine from 'alpinejs'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import Tiptap from '../../../vendor/kiwilan/laravel-steward/lib/editor-lib'
import NotificationsAlpinePlugin from '@/vendor/filament/notifications/dist/module.esm'
// import Tiptap from '~/libs/tiptap.js'

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)

window.Alpine = Alpine

Alpine.data('tiptap', Tiptap)

Alpine.start()
