import * as comix from '@comix/parser'
import Downloader from '../library/downloader'
import TinyGesture from '../library/tinygesture'

interface IComic extends IBook {
  displayGrid?: () => void
  setGrid?: () => Promise<void>
}

let refsAlpine: AlpineRefs
const extensions = ['jpg', 'jpeg']

function comic(): IComic {
  return {
    $store: {
      webreader: {} as IWebreader,
    },
    $watch: (value: string, callback: (value: any) => void) => {
    //
    },
    async initialize(data: string) {
      this.$store.webreader.bookData = JSON.parse(data)

      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-expect-error
      refsAlpine = this.$refs
      this.$store.webreader.navigationOptions.grid = true
      this.$store.webreader.navigationOptions.sizeable = true

      this.setEvents()
      await this.createBook()
    },
    async createBook() {
      const downloader = new Downloader(
        this.$store.webreader.bookData.url,
        this.$store.webreader.bookData.filename,
      )
      await downloader.download()
      this.$store.webreader.bookIsDownloaded = true
      if (downloader.file) {
        const parser = new comix.Parser()
        const comic = await parser.parse(downloader.file)

        this.$store.webreader.imagesList = comic.images.filter((image) => {
          const name = image.name.split('.')
          const extension = name[name.length - 1]
          if (extensions.includes(extension))
            return image
        })
        this.$store.webreader.lastPage
        = this.$store.webreader.imagesList.length - 1
        this.$store.webreader.imagesList = this.$store.webreader.imagesList.sort(
          (a, b) => a.name.localeCompare(b.name, undefined, {
            numeric: true,
            sensitivity: 'base',
          }),
        )

        this.$store.webreader.getConfig()
        await this.setReader()
        this.$store.webreader.isLoading = false

        for (let i = 0; i < this.$store.webreader.imagesList.length; i++) {
          this.$store.webreader.grid.push({
            name: i.toString(),
          })
        }
        await this.setGrid!()
      }
    },
    async setReader() {
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

      this.$store.webreader.saveConfig()
    },
    setEvents() {
      document.addEventListener('DOMContentLoaded', () => {
        const target = document.getElementById('fullScreen')!
        const gesture = new TinyGesture(target)

        gesture.on('tap', () => {
          this.$store.webreader.toggleMenu()
        })
        gesture.on('swiperight', () => {
          this.previous()
        })
        gesture.on('swipeleft', () => {
          this.next()
        })
      })
      document.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft')
          this.previous()

        if (event.key === 'ArrowRight' || event.key === 'Alt')
          this.next()

        if (event.key === 'g')
          this.displayGrid!()
      })
    },

    first() {
      this.$store.webreader.currentPage = 0
      this.$store.webreader.pageRange = this.$store.webreader.currentPage
      this.setReader()
    },
    last() {
      this.$store.webreader.currentPage = this.$store.webreader.lastPage
      this.$store.webreader.pageRange = this.$store.webreader.currentPage
      this.setReader()
    },
    previous() {
      if (this.$store.webreader.currentPage > 0)
        this.$store.webreader.currentPage = this.$store.webreader.currentPage - 1
      else
        this.$store.webreader.currentPage = this.$store.webreader.lastPage

      this.$store.webreader.pageRange = this.$store.webreader.currentPage
      this.setReader()
    },
    next() {
      if (
        this.$store.webreader.currentPage
      < this.$store.webreader.imagesList.length - 1
      )
        this.$store.webreader.currentPage = this.$store.webreader.currentPage + 1
      else
        this.$store.webreader.currentPage = 0

      this.$store.webreader.pageRange = this.$store.webreader.currentPage
      this.setReader()
    },
    changePageRange() {
      this.$store.webreader.currentPage = this.$store.webreader.pageRange
      this.setReader()
    },

    displayGrid() {
      const full = document.getElementById('fullScreen')
      this.$store.webreader.showGrid = !this.$store.webreader.showGrid

      full?.scrollTo({
        top: 0,
        behavior: 'smooth',
      })
    },
    async setGrid() {
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
      grid = grid.sort((a, b) => a.name.localeCompare(b.name, undefined, {
        numeric: true,
        sensitivity: 'base',
      }))
      this.$store.webreader.gridIsAvailable = true
      this.$store.webreader.grid = grid
    },
  }
}

export default comic
