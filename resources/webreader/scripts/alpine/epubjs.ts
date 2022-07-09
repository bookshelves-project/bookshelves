import Epub, { Book, NavItem, Rendition } from 'epubjs'
// import { EpubThemes, dark, tan, defaultStyle } from '../archive/epubjs/theme'
import TinyGesture from '../library/tinygesture'

type EpubThemes = 'dark' | 'light' | 'tan' | 'defaultStyle'

interface IEpub extends IBook {
  book: Book
  rendition: Rendition

  saveProgress: () => void
  setChapter: (chapter: number) => void
  getThemes()
}

let refsAlpine: AlpineRefs

/**
 * Init ebook: https://github.com/futurepress/epub.js/issues/744#issuecomment-492300092
 * Save progress: https://github.com/futurepress/epub.js/issues/691
 */
const epub = (): IEpub => ({
  $store: {
    webreader: {} as IWebreader,
  },
  // eslint-disable-next-line @typescript-eslint/no-empty-function
  $watch: (value: string, callback: (value: any) => void) => {},

  book: {} as Book,
  rendition: {} as Rendition,

  async initialize(data?: string) {
    this.$store.webreader.bookData = data ? JSON.parse(data) : {}

    this.$store.webreader.navigationOptions.sidebar = true

    // @ts-ignore
    refsAlpine = this.$refs
    await this.createBook()
    this.setEvents()
  },
  async createBook() {
    this.$store.webreader.currentPage = 0

    if (localStorage.getItem('webreader_epub_tutorial')) {
      this.$store.webreader.disableTutorial()
    }

    // Initialize the book
    const bookUri = this.$store.webreader.bookData.url
    this.$store.webreader.bookIsDownloaded = true

    this.book = Epub(bookUri!, {})
    this.rendition = this.book.renderTo(refsAlpine.reader!, {
      flow: 'paginated',
      manager: 'continuous',
      spread: 'always',
      width: '100% - 106px',
      height: '100%',
    })

    const themes = this.getThemes()
    this.rendition.themes.registerRules('dark', themes.dark)
    this.rendition.themes.registerRules('tan', themes.tan)
    this.rendition.themes.registerRules('default', themes.defaultStyle)

    const theme: EpubThemes = 'defaultStyle'
    this.rendition.themes.select(theme)
    this.rendition.display()

    // const displayed = rendition.display(
    //   window.location.hash.substr(1) || undefined
    // )
    // displayed.then(function () {
    //   console.log('rendition.currentLocation():', rendition.currentLocation())
    // })

    this.$store.webreader.bookIsDownloaded = true
    this.$store.webreader.isLoading = false
    this.$store.webreader.bookIsReady = true

    await this.setReader()

    // When navigating to the next/previous page
    this.rendition.on('relocated', (locations) => {
      this.$store.webreader.progress = this.book.locations.percentageFromCfi(
        locations.start.cfi
      )
      const current = this.book.locations.locationFromCfi(locations.start.cfi)
      this.$store.webreader.currentPage = parseInt(current.toString())
      this.$store.webreader.pageRange = this.$store.webreader.currentPage
    })

    this.rendition.on('displayed', (locations) => {
      // this.state.rendition.on("displayed", this.onRenditionDisplayedTouchSwipe.bind(this));
    })

    // @ts-ignore
    this.$store.webreader.lastPage = this.book.locations.total
    // this.currentPage = 20
    // this.rendition.display(this.currentPage)

    const save = localStorage.getItem('ebook')
    if (save) {
      this.rendition.display(
        this.book.locations.cfiFromLocation(parseInt(save))
      )
    }
  },
  setEvents() {
    // document.addEventListener('DOMContentLoaded', () => {
    //   const target = document.getElementById('fullScreen')!
    //   const gesture = new TinyGesture(target)

    //   gesture.on('swiperight', () => {
    //     this.previous()
    //   })
    //   gesture.on('swipeleft', () => {
    //     this.next()
    //   })
    // })
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

  async setReader() {
    // Generate location and pagination
    await this.book.ready
    const stored = localStorage.getItem(this.book.key() + '-locations')
    if (stored) {
      this.book.locations.load(stored)
    } else {
      await this.book.locations.generate(2048) // Generates CFI for every X characters (Characters per/page)
    }
    localStorage.setItem(
      this.book.key() + '-locations',
      this.book.locations.save()
    )

    this.$store.webreader.toc = this.book.navigation.toc
  },
  first() {
    this.rendition.display(0)
    this.saveProgress()
  },
  last() {
    // @ts-ignore
    this.rendition.display(this.book.spine.spineItems.length - 1)
    this.saveProgress()
  },
  previous() {
    this.rendition.prev()
    this.saveProgress()
  },
  next() {
    this.rendition.next()
    const cfi = this.book.locations.cfiFromPercentage(
      this.$store.webreader.currentPage / 100
    )
    this.saveProgress()
  },
  saveProgress() {
    localStorage.setItem('ebook', this.$store.webreader.currentPage.toString())
  },
  setChapter(chapter: number) {
    this.rendition.display(chapter)
    this.saveProgress()
  },
  changePageRange() {
    this.rendition.display(
      this.book.locations.cfiFromLocation(this.$store.webreader.pageRange)
    )
    this.$store.webreader.currentPage = this.$store.webreader.pageRange
    this.saveProgress()
  },
  getThemes() {
    const themes = {
      dark: {
        body: {
          background: '#444 !important',
          color: '#fff !important',
        },
        '*': {
          color: 'inherit !important',
          background: 'inherit !important',
        },
        'a:link': {
          color: '#1e83d2 !important',
          'text-decoration': 'none !important',
        },
        'a:link:hover': {
          background: 'rgba(0, 0, 0, 0.1) !important',
        },
      },
      light: {
        body: {},
        '*': {},
        'a:link': {},
        'a:link:hover': {},
      },
      tan: {
        body: {
          background: '#fdf6e3 !important',
          color: '#002b36 !important',
        },
        '*': {
          color: 'inherit !important',
          background: 'inherit !important',
        },
        'a:link': {
          color: '#268bd2 !important',
          'text-decoration': 'none !important',
        },
        'a:link:hover': {
          background: 'rgba(0, 0, 0, 0.1) !important',
        },
      },
      defaultStyle: {
        body: {
          background: '#fdf6e3 !important',
          color: '#002b36 !important',
        },
        '*': {
          color: 'inherit !important',
          background: 'inherit !important',
        },
        'a:link': {
          color: '#268bd2 !important',
          'text-decoration': 'none !important',
        },
        'a:link:hover': {
          background: 'rgba(0, 0, 0, 0.1) !important',
        },
        h1: {
          'font-family': 'Quicksand !important',
        },
        'p, .p': {
          background: 'inherit !important',
          'line-height': '1.5rem',
          'font-size': '1.2rem !important',
          'font-family':
            'ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important',
          'margin-top': '1.25em !important',
          'margin-bottom': '1.25em !important',
        },
      },
    }

    return themes
  },
})

export default epub
