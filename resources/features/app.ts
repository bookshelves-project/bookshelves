import 'clockwork-browser/metrics'
import 'clockwork-browser/toolbar'

// import 'virtual:windi.css'
import './app.css'
import '../css/fonts.css'

// import Swiper, { Pagination } from 'swiper'
// import 'swiper/css/bundle'

// import IMask from 'imask'

import './scripts/gtm'

import slider from './scripts/components/slider'
import simulator from './scripts/components/simulator'
import areaSlider from './scripts/components/area-slider'
import apartmentSlider from './scripts/components/apartment-slider'
import datepicker from './scripts/components/datepicker'
import formReservation from './scripts/components/form-reservation'
import formEstimate from './scripts/components/form-estimate'
import newsletter from './scripts/components/newsletter'
import residenceSubnav from './scripts/components/residence-subnav'
import galleryLightbox from './scripts/components/gallery-lightbox'

// Swiper.use([Pagination])

import Alpine from 'alpinejs'

window.Alpine = Alpine
// window.Swiper = Swiper

const jsonSettings = document.querySelector('[data-json-settings]')
window.settings = jsonSettings ? JSON.parse(jsonSettings.textContent!) : {}

Alpine.magic('currency', () => {
  const formatter = new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  })

  return (amount) => formatter.format(amount)
})

Alpine.magic('percent', () => {
  const formatter = new Intl.NumberFormat('fr-FR', {
    style: 'percent',
  })

  return (amount) => formatter.format(amount / 100)
})

// Alpine.directive('mask-phone', (el) => {
//   IMask(el, {
//     mask: '{\\0}# 00 00 00 00',
//     definitions: {
//       '#': /[1-7|9]/,
//     },
//   })
// })

Alpine.store('sidebar', {
  toggled: false,
  overlay: false,
  sidebar: false,

  toggle() {
    if (this.toggled) {
      this.close()
    } else {
      this.open()
    }
  },
  open() {
    this.toggled = !this.toggled
    setTimeout(() => {
      this.overlay = !this.overlay
      this.sidebar = !this.sidebar
    }, 250)
  },
  close() {
    this.overlay = false
    this.sidebar = false
    setTimeout(() => {
      this.toggled = false
    }, 250)
  },
})

Alpine.data('dropdown', () => ({
  open: false,

  toggle() {
    this.open = !this.open
  },
}))

// Déclaration des composants Alpine.
Alpine.data('slider', slider)
Alpine.data('simulator', simulator)
Alpine.data('apartmentSlider', apartmentSlider)
Alpine.data('areaSlider', areaSlider)
Alpine.data('datepicker', datepicker)
Alpine.data('formReservation', formReservation)
Alpine.data('formEstimate', formEstimate)
Alpine.data('newsletter', newsletter)
Alpine.data('residenceSubnav', residenceSubnav)
Alpine.data('galleryLightbox', galleryLightbox)

Alpine.start()
