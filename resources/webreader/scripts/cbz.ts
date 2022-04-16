import { setup, nextPage, previousPage } from './cbz/index'

type Size = 'sizeFull' | 'sizeHalf' | 'sizeScreen'

const cbz = () => ({
  isReady: false,
  sizeFull: false,
  sizeHalf: false,
  sizeScreen: true,
  init() {
    // @ts-ignore
    return setup(this.$refs)
  },
  previous() {
    previousPage()
  },
  next() {
    nextPage()
  },
  switchSize(size: Size) {
    this.sizeFull = false
    this.sizeHalf = false
    this.sizeScreen = false
    this[size] = true
  },
})

export default cbz
