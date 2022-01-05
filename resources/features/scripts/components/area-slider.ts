import Swiper from 'swiper'

export default () =>
  ({
    // data
    swiperText: null,
    swiperImage: null,

    init() {
      this.swiperImage = new Swiper(this.$refs.swiperImage, {
        slidesPerView: 1,
        loop: true,
      })
      this.swiperImage.on('slideChange', (swiper) => {
        this.swiperText.slideTo(swiper.activeIndex, 1000)
      })

      this.swiperText = new Swiper(this.$refs.swiperText, {
        slidesPerView: 1,
        loop: true,
      })
      this.swiperText.on('slideChange', (swiper) => {
        this.swiperImage.slideTo(swiper.activeIndex, 1000)
      })
    },
    slidePrev() {
      this.swiperText.slidePrev()
    },
    slideNext() {
      this.swiperText.slideNext()
    },
  } as any)
