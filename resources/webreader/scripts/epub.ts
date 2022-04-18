import { epubjsInit } from './epubjs/methods'
import Epub, { Book, NavItem, Rendition } from 'epubjs'
import { EpubThemes, dark, tan, defaultStyle } from './epubjs/theme'
interface AlpineRefs {
  filePath?: HTMLElement
  url?: HTMLElement
  reader?: HTMLElement
  tocElement?: HTMLElement
}

let refsAlpine: AlpineRefs

/**
 * Init ebook: https://github.com/futurepress/epub.js/issues/744#issuecomment-492300092
 * Save progress: https://github.com/futurepress/epub.js/issues/691
 */
const epubjs = () => ({
  isLoading: true,
  readerIsEnabled: false,
  book: {} as Book,
  rendition: {} as Rendition,
  toc: [] as NavItem[],
  navigationIsEnabled: false,
  tutorialIsEnabled: true,
  sidebarWrapperIsEnabled: false,
  sidebarBackdropIsEnabled: false,
  sidebarIsEnabled: false,
  currentPage: 0,
  lastPage: 0,
  progress: 0,
  async init() {
    // @ts-ignore
    // return epubjsInit(this.$refs)
    refsAlpine = this.$refs

    const filePath = refsAlpine.filePath
    const path = filePath?.textContent
    this.currentPage = 0

    if (localStorage.getItem('webreader_epub_tutorial')) {
      this.disableTutorial()
    }

    // Initialize the book
    const bookUri = refsAlpine.url?.textContent
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
    // Display the book
    this.rendition.display()
    // const displayed = rendition.display(
    //   window.location.hash.substr(1) || undefined
    // )
    // displayed.then(function () {
    //   console.log('rendition.currentLocation():', rendition.currentLocation())
    // })

    this.isLoading = false
    this.readerIsEnabled = true

    // Generate location and pagination
    await this.book.ready
    const stored = localStorage.getItem(this.book.key() + '-locations')
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

    // When navigating to the next/previous page
    this.rendition.on('relocated', (locations) => {
      this.progress = this.book.locations.percentageFromCfi(locations.start.cfi)
      // console.log('Progress:', this.progress) // The % of how far along in the book you are
      // console.log(
      //   'Current Page:',
      //   this.book.locations.locationFromCfi(locations.start.cfi)
      // )
      const current = this.book.locations.locationFromCfi(locations.start.cfi)
      this.currentPage = parseInt(current.toString())
      // console.log('Total Pages:', this.book.locations.total)
    })
    this.lastPage = this.book.locations.total
    // this.currentPage = 20
    // this.rendition.display(this.currentPage)

    const save = localStorage.getItem('ebook')
    if (save) {
      this.rendition.display(
        this.book.locations.cfiFromLocation(parseInt(save))
      )
    }
  },
  setToc() {
    this.toc = this.book.navigation.toc
  },
  setChapter(chapter) {
    this.rendition.display(chapter)
  },
  read() {
    this.readerIsEnabled = true

    if (refsAlpine.reader) {
      this.rendition.attachTo(refsAlpine.reader)
      this.rendition.display()
      console.log(this.rendition)

      this.rendition.themes.registerRules('dark', dark)
      this.rendition.themes.registerRules('tan', tan)
      this.rendition.themes.registerRules('default', defaultStyle)

      const theme: EpubThemes = 'defaultStyle'
      this.rendition.themes.select(theme)

      this.rendition.start()
      this.setToc()
      // this.book.rendition.generatePagination('200px', '200px')
      this.book.locations.generate(2000)
      this.rendition.on('relocated', (location) => {
        this.book.locations.locationFromCfi(location.start.cfi)
      })
    }
  },
  previous() {
    this.rendition.prev()
  },
  next() {
    this.rendition.next()
    const cfi = this.book.locations.cfiFromPercentage(this.currentPage / 100)
    localStorage.setItem('ebook', this.currentPage.toString())
  },
  first() {
    this.rendition.display(0)
  },
  last() {
    // @ts-ignore
    this.rendition.display(this.book.spine.spineItems.length - 1)
  },
  disableTutorial() {
    this.tutorialIsEnabled = false
    localStorage.setItem('webreader_epub_tutorial', 'false')
  },
  toggleSidebar() {
    if (this.sidebarWrapperIsEnabled) {
      this.closeSidebar()
    } else {
      this.openSidebar()
    }
  },
  openSidebar() {
    this.sidebarWrapperIsEnabled = true
    setTimeout(() => {
      this.sidebarBackdropIsEnabled = true
      this.sidebarIsEnabled = true
    }, 300)
  },
  closeSidebar() {
    this.sidebarBackdropIsEnabled = false
    this.sidebarIsEnabled = false
    setTimeout(() => {
      this.sidebarWrapperIsEnabled = false
    }, 300)
  },
})

export default epubjs

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
//   setChapter(chapter) {
//     this.rendition.display(chapter)
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
//   disableTutorial() {
//     this.tutorialIsEnabled = false
//     localStorage.setItem('webreader_epub_tutorial', 'false')
//   },
//   toggleSidebar() {
//     if (this.sidebarWrapperIsEnabled) {
//       this.closeSidebar()
//     } else {
//       this.openSidebar()
//     }
//   },
//   openSidebar() {
//     this.sidebarWrapperIsEnabled = true
//     setTimeout(() => {
//       this.sidebarBackdropIsEnabled = true
//       this.sidebarIsEnabled = true
//     }, 300)
//   },
//   closeSidebar() {
//     this.sidebarBackdropIsEnabled = false
//     this.sidebarIsEnabled = false
//     setTimeout(() => {
//       this.sidebarWrapperIsEnabled = false
//     }, 300)
//   },
// })

// export default epubjs
