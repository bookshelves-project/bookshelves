import Alpine from 'alpinejs'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import NotificationsAlpinePlugin from '../../../vendor/filament/notifications/dist/module.esm'
import embed from './modules/iframely'

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.data('embed', embed)

window.Alpine = Alpine

Alpine.start()
