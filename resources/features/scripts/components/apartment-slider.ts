import Swiper from 'swiper'

const apartmentSlider = (currentType: string, nbSliders: number) =>
  ({
    currentType,
    nbSliders,
    sliders: {},
    swiperConfig: {
      speed: 1000,
      loop: true,
      slidesPerView: 1,
      spaceBetween: 0,
    },
    async init() {
      await this.initSliders()
      await this.setListeners()
    },
    initSliders() {
      for (let i = 1; i <= this.nbSliders; i++) {
        const index = `t${i}`
        this.sliders[`sliderContent${index}`] = new Swiper(
          this.$refs[`sliderContent${index}`],
          this.swiperConfig
        )
        this.sliders[`sliderImage${index}`] = new Swiper(
          this.$refs[`sliderImage${index}`],
          this.swiperConfig
        )
      }
    },
    setListeners() {
      for (let i = 1; i <= this.nbSliders; i++) {
        const index = `t${i}`
        this.sliders[`sliderImage${index}`].on('slideChange', (swiper) => {
          this.sliders[`sliderContent${index}`].slideTo(
            swiper.activeIndex,
            1000
          )
        })

        this.sliders[`sliderContent${index}`].on('slideChange', (swiper) => {
          this.sliders[`sliderImage${index}`].slideTo(swiper.activeIndex, 1000)
        })
      }
    },
    onChangeType(type) {
      this.currentType = type
      this.$nextTick(() => {
        this.sliders[`sliderContent${this.currentType}`].slideTo(1, 0)
        this.sliders[`sliderImage${this.currentType}`].slideTo(1, 0)
      })
    },
    slideNext() {
      this.sliders[`sliderContent${this.currentType}`].slideNext()
    },
    slidePrev() {
      this.sliders[`sliderContent${this.currentType}`].slidePrev()
    },
  } as any)

export default apartmentSlider
