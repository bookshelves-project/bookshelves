import * as comix from '@comix/parser'

type Size = 'sizeFull' | 'sizeLarge' | 'sizeScreen'
interface AlpineRefs {
  fileName: HTMLElement
  url: HTMLElement
  filePath: HTMLElement
  fileFormat: HTMLElement
  current: HTMLImageElement
}

interface Config {
  page?: string
  size?: Size
  locked?: boolean
}

let refsAlpine: AlpineRefs
const extensions = ['jpg', 'jpeg']

const cbz = () => ({
  filename: '',
  url: '',
  imagesList: [] as comix.ComicImage[],
  isLoading: true,
  imageIsReady: false,
  showNavigation: true,
  navigationIsLock: true,
  sizeFull: false,
  sizeLarge: false,
  sizeScreen: true,
  currentSize: 'sizeScreen' as Size,
  isFullscreen: false,
  informationEnabled: false,
  currentPage: 0,
  lastPage: 0,
  isDoubleSpace: 0,
  configKey: '',
  async init() {
    // @ts-ignore
    refsAlpine = this.$refs
    this.url = refsAlpine.url.textContent!
    this.filename = refsAlpine.fileName.textContent!
    this.configKey = refsAlpine.fileName.textContent!

    const response = await fetch(this.url)
    const blob = await response.blob()
    const file = new File([blob], this.filename)

    const parser = new comix.Parser()
    const comic = await parser.parse(file)

    this.imagesList = comic.images.filter((image) => {
      const name = image.name.split('.')
      const extension = name[name.length - 1]
      if (extensions.includes(extension)) {
        return image
      }
    })
    this.lastPage = this.imagesList.length - 1
    this.imagesList = this.imagesList.sort((a, b) =>
      a.name.localeCompare(b.name, undefined, {
        numeric: true,
        sensitivity: 'base',
      })
    )

    this.getConfig()
    await this.setImage()
    this.isLoading = false

    this.events()
  },
  async setImage() {
    const imageBuffer = await this.imagesList[this.currentPage].read()

    const arrayBufferView = new Uint8Array(imageBuffer)
    const imageBlob = new Blob([arrayBufferView], { type: 'image/jpg' })
    const imageUrl = URL.createObjectURL(imageBlob)

    const full = document.getElementById('fullScreen')
    full?.scrollTo({
      top: 0,
      behavior: 'smooth',
    })
    refsAlpine.current.setAttribute('src', imageUrl)
    this.imageIsReady = true

    this.saveConfig()
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
    } else {
      this.currentPage = this.lastPage
    }
    this.setImage()
  },
  next() {
    if (this.currentPage < this.imagesList.length - 1) {
      this.currentPage = this.currentPage + 1
    } else {
      this.currentPage = 0
    }
    this.setImage()
  },
  switchSize(size: Size) {
    this.sizeFull = false
    this.sizeLarge = false
    this.sizeScreen = false
    this[size] = true
    this.currentSize = size

    this.saveConfig()
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

    this.saveConfig()
  },
  deleteProgression() {
    this.currentPage = 0
    this.currentSize = 'sizeScreen'
    this.navigationIsLock = true

    this.saveConfig()
  },
  saveConfig() {
    const config: Config = {
      page: this.currentPage.toString(),
      size: this.currentSize,
      locked: this.navigationIsLock,
    }
    localStorage.setItem(this.filename, JSON.stringify(config))
  },
  getConfig(): Config {
    let config: Config = {
      page: '0',
      size: 'sizeScreen',
      locked: true,
    }
    if (localStorage.getItem(this.filename) !== null) {
      const storage = localStorage.getItem(this.filename)!
      config = JSON.parse(storage)
    }
    this.currentPage = parseInt(config.page!)
    this.switchSize(config.size!)
    this.navigationIsLock = config.locked!
    this.showNavigation = config.locked!

    return config
  },
  events() {
    document.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowLeft') {
        this.previous()
      }
      if (
        event.key === 'ArrowRight' ||
        event.key === 'Control' ||
        event.key === 'Meta'
      ) {
        this.next()
      }

      const full = document.getElementById('fullScreen')
      if (event.key === 'ArrowUp') {
        event.preventDefault()
        full?.scrollBy({ top: -100, behavior: 'smooth' })
      }
      if (event.key === 'ArrowDown' || event.key === ' ') {
        event.preventDefault()
        full?.scrollBy({ top: 100, behavior: 'smooth' })
      }

      if (event.key === 'f') {
        this.switchSize('sizeFull')
      }
      if (event.key === 'l') {
        this.switchSize('sizeLarge')
      }
      if (event.key === 's') {
        this.switchSize('sizeScreen')
      }
      if (event.key === 'e') {
        if (this.isFullscreen) {
          this.fullscreenExit()
        } else {
          this.fullscreen()
        }
      }
      if (event.key === 'o') {
        this.lock()
      }
      if (event.key === 'i') {
        this.informationEnabled = !this.informationEnabled
      }
    })
  },
  commands() {
    interface Command {
      key?: string[]
      label?: string
    }
    const commands: Command[] = [
      {
        key: ['E'],
        label: 'Fullscreen/Exit Fullscreen',
      },
      {
        key: ['↑', '↓', 'Space'],
        label: 'Scroll page',
      },
      {
        key: ['←'],
        label: 'Previous page',
      },
      {
        key: ['⌘', 'Ctrl', '→'],
        label: 'Next page',
      },
      {
        key: ['F'],
        label: 'Size full width',
      },
      {
        key: ['L'],
        label: 'Size large',
      },
      {
        key: ['S'],
        label: 'Size height screen',
      },
      {
        key: ['I'],
        label: 'Show informations',
      },
      {
        key: ['O'],
        label: 'Lock navigation',
      },
    ]

    return commands
  },
})

export default cbz
