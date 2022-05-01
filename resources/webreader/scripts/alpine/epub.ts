import EpubParser from '../library/epub-parser'
import TinyGesture from '../library/tinygesture'

interface IEpub extends IBook {
  page: Page
  size: number
  epubParser: EpubParser

  updateProgress: (progress: Progress) => void
  saveProgress: () => void
  setChapter: (page: number) => void
}

const epub = (): IEpub => ({
  $store: {
    webreader: {} as IWebreader,
  },
  // eslint-disable-next-line @typescript-eslint/no-empty-function
  $watch: (value: string, callback: (value: any) => void) => {},
  page: {
    text: '',
    number: 1,
    chapter: 1,
  } as Page,
  size: 1.2,
  epubParser: {} as EpubParser,

  async initialize(data?: string) {
    this.$store.webreader.bookData = data ? JSON.parse(data) : {}

    this.$store.webreader.navigationOptions.sidebar = true

    // @ts-ignore
    refsAlpine = this.$refs
    await this.createBook()
    this.setEvents()
  },
  async createBook() {
    const epubParser = new EpubParser(
      this.$store.webreader.bookData.url,
      this.size
    )
    this.epubParser = await epubParser.parse()
    this.$store.webreader.toc = this.epubParser.tableOfContent
    this.$store.webreader.bookIsDownloaded = true
    this.setReader()
  },
  setReader() {
    this.$store.webreader.isLoading = false

    this.page = this.epubParser.pages[this.$store.webreader.currentPage]
    this.$store.webreader.lastPage = this.epubParser.total
    this.$store.webreader.toc = this.epubParser.tableOfContent

    this.$store.webreader.bookIsReady = true
  },
  first() {
    this.updateProgress(this.epubParser.first())
  },
  last() {
    this.updateProgress(this.epubParser.last())
  },
  previous() {
    this.updateProgress(this.epubParser.previous())
  },
  next() {
    this.updateProgress(this.epubParser.next())
  },
  saveProgress() {
    localStorage.setItem('ebook', this.$store.webreader.currentPage.toString())
  },
  updateProgress(progress: Progress) {
    this.$store.webreader.pageRange = progress.number
    this.$store.webreader.currentPage = progress.number
    this.$store.webreader.chapter = progress.page.chapter!
    this.page = progress.page
  },
  setChapter(page: number) {
    this.updateProgress(this.epubParser.jump(page))
  },
  changePageRange() {
    this.updateProgress(this.epubParser.jump(this.$store.webreader.pageRange))
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
      if (event.key === 'ArrowLeft') {
        this.previous()
      }
      if (event.key === 'ArrowRight' || event.key === 'Alt') {
        this.next()
      }

      if (event.key === 'g') {
        this.$store.webreader.toggleSidebar()
      }
    })
  },
})

export default epub
