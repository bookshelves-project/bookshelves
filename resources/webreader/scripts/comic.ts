import * as comix from '@comix/parser'

type Size = 'sizeFull' | 'sizeLarge' | 'sizeScreen'
interface AlpineRefs {
  fileName?: HTMLElement
  url?: HTMLElement
  filePath?: HTMLElement
  fileFormat?: HTMLElement
  current?: HTMLImageElement
  isLoading?: HTMLElement
  isNotReady?: HTMLElement
}

let refsAlpine: AlpineRefs
const extensions = ['jpg', 'jpeg']
let imagesList: comix.ComicImage[] = []
let fileName: string
let url: string

const cbz = () => ({
  isLoading: true,
  imageIsReady: false,
  showNavigation: true,
  navigationIsLock: false,
  sizeFull: false,
  sizeLarge: false,
  sizeScreen: true,
  isFullscreen: false,
  currentPage: 0,
  lastPage: 0,
  async init() {
    // @ts-ignore
    refsAlpine = this.$refs
    fileName = refsAlpine.fileName?.textContent as unknown as string
    url = refsAlpine.url?.textContent as unknown as string

    const response = await fetch(url)
    const blob = await response.blob()
    const file = new File([blob], fileName)

    const parser = new comix.Parser()
    const comic = await parser.parse(file)

    imagesList = comic.images.filter((image) => {
      const name = image.name.split('.')
      const extension = name[name.length - 1]
      if (extensions.includes(extension)) {
        return image
      }
    })
    this.lastPage = imagesList.length - 1

    await this.setImage()
    this.isLoading = false

    document.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowLeft') {
        this.previous()
      }
      if (event.key === 'ArrowRight') {
        this.next()
      }
      const full = document.getElementById('fullScreen')
      if (event.key === 'ArrowUp') {
        event.preventDefault()
        full?.scrollBy({ top: -100, behavior: 'smooth' })
      }
      if (event.key === 'ArrowDown') {
        event.preventDefault()
        full?.scrollBy({ top: 100, behavior: 'smooth' })
      }
    })
  },
  async setImage() {
    const imageBuffer = await imagesList[this.currentPage].read()

    const arrayBufferView = new Uint8Array(imageBuffer)
    const imageBlob = new Blob([arrayBufferView], { type: 'image/jpg' })
    const imageUrl = URL.createObjectURL(imageBlob)

    const full = document.getElementById('fullScreen')
    full?.scrollTo({
      top: 0,
      behavior: 'smooth',
    })
    refsAlpine.current?.setAttribute('src', imageUrl)
    this.imageIsReady = true
  },
  first() {
    this.currentPage = 0
    this.setImage()
  },
  last() {
    this.currentPage = this.lastPage
    this.setImage()
  },
  previous() {
    if (this.currentPage > 0) {
      this.currentPage = this.currentPage - 1
    }
    this.setImage()
  },
  next() {
    if (this.currentPage < imagesList.length - 1) {
      this.currentPage = this.currentPage + 1
    }
    this.setImage()
  },
  switchSize(size: Size) {
    this.sizeFull = false
    this.sizeLarge = false
    this.sizeScreen = false
    this[size] = true
  },
  fullscreen() {
    refsAlpine.fileName?.requestFullscreen()
    this.isFullscreen = true
  },
  fullscreenExit() {
    document.exitFullscreen()
    this.isFullscreen = false
  },
  lock() {
    this.navigationIsLock = !this.navigationIsLock
    this.showNavigation = this.navigationIsLock
  },
})

export default cbz
