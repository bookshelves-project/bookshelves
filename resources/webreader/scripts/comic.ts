import * as comix from '@comix/parser'
import { download } from './download'

interface IComic extends IBook {}

interface AlpineRefs {
  reader: HTMLImageElement
}

let refsAlpine: AlpineRefs
const extensions = ['jpg', 'jpeg']

const comic = () => ({
  list: [],
  $store: {
    webreader: {} as IWebreader,
  },
  // eslint-disable-next-line @typescript-eslint/no-empty-function
  $watch: (value: string, callback: (value: any) => void) => {},
  init() {
    this.$watch('$store.webreader.bookIsReady', (isReady) => {
      console.log('ready')
    })
    this.$watch('$store.webreader.showGrid', (isReady) => {
      console.log('grid')
      if (!this.$store.webreader.gridIsAvailable) {
        setTimeout(async () => {
          await this.getGrid()
        }, 500)
      }
    })
  },
  async initialize(data: string) {
    this.$store.webreader.bookData = JSON.parse(data)

    // @ts-ignore
    refsAlpine = this.$refs
    await this.createBook()
  },
  async createBook() {
    const file = await download(
      this.$store.webreader.bookData.url,
      this.$store.webreader.bookData.filename
    )
    if (file) {
      const parser = new comix.Parser()
      const comic = await parser.parse(file)

      this.$store.webreader.imagesList = comic.images.filter((image) => {
        const name = image.name.split('.')
        const extension = name[name.length - 1]
        if (extensions.includes(extension)) {
          return image
        }
      })
      this.$store.webreader.lastPage =
        this.$store.webreader.imagesList.length - 1
      this.$store.webreader.imagesList = this.$store.webreader.imagesList.sort(
        (a, b) =>
          a.name.localeCompare(b.name, undefined, {
            numeric: true,
            sensitivity: 'base',
          })
      )

      this.getConfig()
      await this.setImage()
      this.$store.webreader.isLoading = false

      this.events()
      for (let i = 0; i < this.$store.webreader.imagesList.length; i++) {
        this.$store.webreader.grid.push({
          name: i.toString(),
        })
      }
    }
  },
  checkIsReady() {
    console.log(this.$store.webreader.isLoading)
  },
  async setImage() {
    const imageBuffer = await this.$store.webreader.imagesList[
      this.$store.webreader.currentPage
    ].read()

    const arrayBufferView = new Uint8Array(imageBuffer)
    const imageBlob = new Blob([arrayBufferView], { type: 'image/jpg' })
    const imageUrl = URL.createObjectURL(imageBlob)

    const full = document.getElementById('fullScreen')
    full?.scrollTo({
      top: 0,
      behavior: 'smooth',
    })
    refsAlpine.reader.setAttribute('src', imageUrl)
    this.$store.webreader.bookIsReady = true

    this.saveConfig()
  },
  first() {
    this.$store.webreader.currentPage = 0
    this.setImage()
  },
  last() {
    this.$store.webreader.currentPage = this.$store.webreader.lastPage
    this.setImage()
  },
  previous() {
    if (this.$store.webreader.currentPage > 0) {
      this.$store.webreader.currentPage = this.$store.webreader.currentPage - 1
    } else {
      this.$store.webreader.currentPage = this.$store.webreader.lastPage
    }
    this.setImage()
  },
  next() {
    if (
      this.$store.webreader.currentPage <
      this.$store.webreader.imagesList.length - 1
    ) {
      this.$store.webreader.currentPage = this.$store.webreader.currentPage + 1
    } else {
      this.$store.webreader.currentPage = 0
    }
    this.setImage()
  },
  switchSize(size: Size) {
    this.$store.webreader.sizeFull = false
    this.$store.webreader.sizeLarge = false
    this.$store.webreader.sizeScreen = false
    this.$store.webreader[size] = true
    this.$store.webreader.currentSize = size

    this.saveConfig()
  },
  fullscreen() {
    document.getElementById('fullScreen')?.requestFullscreen()
    this.$store.webreader.isFullscreen = true
  },
  fullscreenExit() {
    document.exitFullscreen()
    this.$store.webreader.isFullscreen = false
  },
  lock() {
    this.$store.webreader.navigationIsLock =
      !this.$store.webreader.navigationIsLock
    this.$store.webreader.showNavigation =
      this.$store.webreader.navigationIsLock

    this.saveConfig()
  },
  deleteProgression() {
    this.$store.webreader.currentPage = 0
    this.$store.webreader.currentSize = 'sizeScreen'
    this.$store.webreader.navigationIsLock = true

    this.saveConfig()
  },
  displayGrid() {
    const full = document.getElementById('fullScreen')
    this.$store.webreader.showGrid = !this.$store.webreader.showGrid

    full?.scrollTo({
      top: 0,
      behavior: 'smooth',
    })
  },
  async getGrid() {
    let grid: GridImg[] = []
    for (const file of this.$store.webreader.imagesList) {
      const imageBuffer = await file.read()
      const arrayBufferView = new Uint8Array(imageBuffer)
      const imageBlob = new Blob([arrayBufferView], { type: 'image/jpg' })
      const imageUrl = URL.createObjectURL(imageBlob)
      grid.push({
        name: file.name,
        img: imageUrl,
      })
    }
    grid = grid.sort((a, b) =>
      a.name.localeCompare(b.name, undefined, {
        numeric: true,
        sensitivity: 'base',
      })
    )
    this.$store.webreader.gridIsAvailable = true
    this.$store.webreader.grid = grid
  },
  saveConfig() {
    const config: StorageConfig = {
      size: this.$store.webreader.currentSize,
      locked: this.$store.webreader.navigationIsLock,
    }
    localStorage.setItem(
      this.$store.webreader.configKey,
      JSON.stringify(config)
    )
    localStorage.setItem(
      this.$store.webreader.bookData.filename,
      this.$store.webreader.currentPage.toString()
    )
  },
  getConfig(): StorageConfig {
    let config: StorageConfig = {
      size: 'sizeScreen',
      locked: true,
    }
    if (localStorage.getItem(this.$store.webreader.configKey) !== null) {
      const storage = localStorage.getItem(this.$store.webreader.configKey)!
      config = JSON.parse(storage)
    }
    if (
      localStorage.getItem(this.$store.webreader.bookData.filename) !== null
    ) {
      const currentPage = localStorage.getItem(
        this.$store.webreader.bookData.filename
      )!
      this.$store.webreader.currentPage = parseInt(currentPage)
    }
    this.switchSize(config.size!)
    this.$store.webreader.navigationIsLock = config.locked!
    this.$store.webreader.showNavigation = config.locked!

    return config
  },
  events() {
    document.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowLeft') {
        this.previous()
      }
      if (event.key === 'ArrowRight' || event.key === 'Alt') {
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
        if (this.$store.webreader.isFullscreen) {
          this.fullscreenExit()
        } else {
          this.fullscreen()
        }
      }
      if (event.key === 'o') {
        this.lock()
      }
      if (event.key === 'i') {
        this.$store.webreader.informationEnabled =
          !this.$store.webreader.informationEnabled
      }
      if (event.key === 'g') {
        this.displayGrid()
      }
    })
  },
  commands() {
    const commands: Command[] = [
      {
        key: ['E'],
        label: 'Fullscreen/Exit Fullscreen',
      },
      {
        key: ['G'],
        label:
          'Display all pages (this features need some time to loading after init)',
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
        key: ['Alt', '→'],
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
    this.$store.webreader.commands = commands
  },
})

export default comic
