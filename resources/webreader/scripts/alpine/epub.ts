import Epub, { Book, NavItem, Rendition } from 'epubjs'
import { EpubThemes, dark, tan, defaultStyle } from './epubjs/theme'
import TinyGesture from '../library/tinygesture'

interface IEpub extends IBook {
  book: Book
  rendition: Rendition

  setChapter: (chapter: number) => void
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

    this.rendition.themes.registerRules('dark', dark)
    this.rendition.themes.registerRules('tan', tan)
    this.rendition.themes.registerRules('default', defaultStyle)

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
    // @ts-ignore
    this.$store.webreader.lastPage = this.book.locations.total
    // this.currentPage = 20
    // this.rendition.display(this.currentPage)

    // const save = localStorage.getItem('ebook')
    // if (save) {
    //   this.rendition.display(
    //     this.book.locations.cfiFromLocation(parseInt(save))
    //   )
    // }
  },
  setEvents() {
    document.addEventListener('DOMContentLoaded', () => {
      const target = document.getElementById('fullScreen')!
      const gesture = new TinyGesture(target)

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

  async setReader() {
    // Generate location and pagination
    await this.book.ready
    const stored = localStorage.getItem(this.book.key() + '-locations')
    // @ts-ignore
    console.log('metadata:', this.book.package.metadata)
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
  },
  last() {
    // @ts-ignore
    this.rendition.display(this.book.spine.spineItems.length - 1)
  },
  previous() {
    this.rendition.prev()
  },
  next() {
    this.rendition.next()
    const cfi = this.book.locations.cfiFromPercentage(
      this.$store.webreader.currentPage / 100
    )
    localStorage.setItem('ebook', this.$store.webreader.currentPage.toString())
  },
  setChapter(chapter: number) {
    this.rendition.display(chapter)
  },
  changePageRange() {
    this.rendition.display(
      this.book.locations.cfiFromLocation(this.$store.webreader.pageRange)
    )
  },
})

export default epub

// import { epubjsInit } from './epubjs/methods'
// import { Book, NavItem, Rendition } from 'epubjs'
// import { EpubThemes, dark, tan, defaultStyle } from './epubjs/theme'
// interface AlpineRefs {
//   filePath?: HTMLElement
//   reader?: HTMLElement
//   tocElement?: HTMLElement
// }

// let refsAlpine: AlpineRefs

// const epubjs = () => ({
//   isLoading: true,
//   readerIsEnabled: false,
//   book: {} as Book,
//   rendition: {} as Rendition,
//   toc: [] as NavItem[],
//   navigationIsEnabled: false,
//   tutorialIsEnabled: true,
//   sidebarWrapperIsEnabled: false,
//   sidebarBackdropIsEnabled: false,
//   sidebarIsEnabled: false,
//   currentPage: 0,
//   lastPage: 0,
//   async init() {
//     // @ts-ignore
//     // return epubjsInit(this.$refs)
//     refsAlpine = this.$refs

//     const filePath = refsAlpine.filePath
//     const path = filePath?.textContent
//     this.currentPage = 0

//     if (localStorage.getItem('webreader_epub_tutorial')) {
//       this.disableTutorial()
//     }

//     const info = {
//       toc: {},
//       lastOpen: 0,
//       path,
//       highlights: [],
//     }
//     info.lastOpen = new Date().getTime()

//     this.book = new Book(info.path!)
//     this.rendition = new Rendition(this.book, {
//       width: '100%',
//       height: '100%',
//       manager: 'default',
//       spread: 'always',
//       infinite: true,
//     })

//     await this.book.locations.generate(
//       750 * (window.innerWidth / 375) * (14 / 16)
//     )
//     await this.book.ready
//     this.isLoading = false
//     this.read()
//     this.book.rendition = this.rendition
//     // this.lastPage = this.book.pageList.pageList.length
//     // console.log(this.book.pageList)
//     // console.log(this.book.locations.length())
//     // console.log(this.rendition.location.start.displayed.total)
//     // await this.book.locations.generate(100)
//     // this.book.locations.generate(600)
//   },
//   setToc() {
//     this.toc = this.book.navigation.toc
//   },
//   read() {
//     this.readerIsEnabled = true

//     if (refsAlpine.reader) {
//       this.rendition.attachTo(refsAlpine.reader)
//       this.rendition.display()
//       console.log(this.rendition)

//       this.rendition.themes.registerRules('dark', dark)
//       this.rendition.themes.registerRules('tan', tan)
//       this.rendition.themes.registerRules('default', defaultStyle)

//       const theme: EpubThemes = 'defaultStyle'
//       this.rendition.themes.select(theme)

//       this.rendition.start()
//       this.setToc()
//       // this.book.rendition.generatePagination('200px', '200px')
//       this.book.locations.generate(2000)
//       this.rendition.on('relocated', (location) => {
//         this.book.locations.locationFromCfi(location.start.cfi)
//       })
//     }
//   },
//   previous() {
//     this.rendition.prev()
//     console.clear()
//   },
//   async next() {
//     this.rendition.next()
//     this.currentPage = this.currentPage + 1
//     const renditionLocation = this.rendition.currentLocation()
//     const total = this.rendition.location.start.displayed.total
//     console.log(renditionLocation)
//     console.log(total)
//   },
//   first() {
//     this.rendition.display(0)
//     console.clear()
//   },
//   last() {
//     // @ts-ignore
//     this.rendition.display(book.spine.spineItems.length - 1)
//     console.clear()
//   },
// })

// export default epubjs
