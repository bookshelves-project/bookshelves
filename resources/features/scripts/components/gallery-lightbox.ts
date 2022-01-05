import Swiper from 'swiper'

const galleryLightbox = () =>
  ({
    swiper: null,
    swiperConfig: {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      breakpoints: {
        640: {
          allowTouchMove: false,
          slidesPerView: 6,
        },
      },
    },

    lightboxOpened: false,
    swiperLightbox: null,
    swiperConfigLightbox: {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
    },

    init() {
      this.swiper = new Swiper(this.$refs.gallery, this.swiperConfig)
      this.swiperLightbox = new Swiper(
        this.$refs.galleryLightbox,
        this.swiperConfigLightbox
      )

      this.swiper.on('click', (swiper) => {
        this.swiperLightbox.slideTo(swiper.clickedIndex, 1000)
        this.lightboxOpened = true
      })

      // Blocage du scroll window si la lightbox est ouverte
      this.$watch('lightboxOpened', (value) => {
        document.body.style.overflowY = value ? 'hidden' : 'scroll'
      })
    },
  } as any)

export default galleryLightbox
