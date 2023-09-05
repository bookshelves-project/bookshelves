import type { Book, Rendition } from 'epubjs'
import Epub from 'epubjs'
import type { AlpineComponent } from 'alpinejs'
import type { EpubThemes } from '../assets'
import { themes } from '../assets'

interface IBook {
  title: string
  titleFull: string
  authors?: string[]
  series?: string
  volume?: string
  filename: string
  url: string
  path: string
  downloadUrl: string
  format: string
  size: number
}

/**
 * epub.js module
 */
function epub(): AlpineComponent<{
  currentPage: number
  pageRange: number

  currentBook: IBook
  epubBook: Book
  epubRendition: Rendition
  boot: (book: string) => Promise<void>
  create: () => Promise<void>
  reader: () => Promise<void>
  saveProgress: () => void
  navFirst: () => void
  navLast: () => void
  navPrevious: () => void
  navNext: () => void
  setChapter: (chapter: number) => void
  changePageRange: () => void
}> {
  return {
    currentPage: 0,
    pageRange: 0,
    chapters: [],

    currentBook: {} as IBook,
    epubBook: {} as Book,
    epubRendition: {} as Rendition,

    async boot(book: string) {
      this.currentBook = JSON.parse(book)
      await this.create()
    },
    /**
     * Create book and rendition.
     */
    async create() {
      this.epubBook = Epub(this.currentBook.path)
      this.epubRendition = this.epubBook.renderTo(this.$refs.webreader, {
        flow: 'paginated',
        manager: 'continuous',
        spread: 'always',
        width: '100% - 106px',
        height: '100%',
      })

      this.epubRendition.themes.registerRules('dark', themes.dark)
      this.epubRendition.themes.registerRules('tan', themes.tan)
      this.epubRendition.themes.registerRules('default', themes.defaultStyle)

      const theme: EpubThemes = 'defaultStyle'
      this.epubRendition.themes.select(theme)
      await this.epubRendition.display()

      await this.reader()
    },
    /**
     * Generate location and pagination.
     */
    async reader() {
      await this.epubBook.ready
      const stored = localStorage.getItem(`${this.epubBook.key()}-locations`)
      if (stored)
        this.epubBook.locations.load(stored)
      else
        await this.epubBook.locations.generate(2048) // Generates CFI for every X characters (Characters per/page)

      localStorage.setItem(
        `${this.epubBook.key()}-locations`,
        this.epubBook.locations.save(),
      )

      // this.$store.webreader.toc = this.epubBook.navigation.toc
    },
    saveProgress() {
      // localStorage.setItem('ebook', this.$store.webreader.currentPage.toString())
      localStorage.setItem('ebook', this.currentPage.toString())
    },
    setChapter(chapter: number) {
      this.epubRendition.display(chapter)
      this.saveProgress()
    },
    changePageRange() {
      this.epubRendition.display(
        // this.epubBook.locations.cfiFromLocation(this.$store.webreader.pageRange),
        this.epubBook.locations.cfiFromLocation(this.pageRange),
      )
      // this.$store.webreader.currentPage = this.$store.webreader.pageRange
      this.saveProgress()
    },
    async navFirst() {
      await this.epubRendition.display(0)
      this.saveProgress()
    },
    async navLast() {
      // this.epubBook.locations.load('100')

      // this.epubRendition.display(this.epubBook.spine.spineItems.length - 1)
      // this.saveProgress()
    },
    async navPrevious() {
      await this.epubRendition.prev()
      this.saveProgress()
    },
    async navNext() {
      await this.epubRendition.next()
      // const cfi = this.epubBook.locations.cfiFromPercentage(
      //   this.$store.webreader.currentPage / 100,
      // )
      this.saveProgress()
    },
  }
}

export default epub
