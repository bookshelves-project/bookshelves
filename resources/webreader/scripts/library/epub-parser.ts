// import EpubParserUtils from './epub-parser-utils'

// export default class EpubParser {
//   url: string
//   size: number

//   zip: ZipFile[] = []
//   zipNcx: ZipFile = {}
//   zipOpf: ZipFile = {}
//   spine: string[] = []
//   cover: ZipFile = {}

//   pages: Page[] = []
//   currentPageIndex = 0
//   currentPage: Page = {}
//   tableOfContent: EpubParserNavItem[] = []
//   total = 0
//   textHeight = 0
//   epubParserUtils: EpubParserUtils

//   constructor(url: string, size: number) {
//     this.url = url
//     this.size = size
//     this.epubParserUtils = new EpubParserUtils()
//   }

//   parse = async () => {
//     this.zip = await this.epubParserUtils.extractFilesJsZip(this.url)
//     this.setMedatadataFiles()
//     this.setSpine()
//     this.setCover()
//     this.setPages()
//     this.setTableOfContents()

//     this.currentPage = this.pages[0]
//     this.total = this.pages.length - 1

//     return this
//   }

//   /**
//    * Set `zipNcx` and `zipOpf`.
//    */
//   private setMedatadataFiles = () => {
//     this.zip.forEach((file) => {
//       if (['ncx'].includes(file.extension!)) {
//         this.zipNcx = file
//       } else if (['opf'].includes(file.extension!)) {
//         this.zipOpf = file
//       }
//     })
//   }

//   /**
//    * Generate all EPUB `pages`.
//    */
//   private setPages = () => {
//     const vw = Math.max(
//       document.documentElement.clientWidth || 0,
//       window.innerWidth || 0
//     )
//     const vh = Math.max(
//       document.documentElement.clientHeight || 0,
//       window.innerHeight || 0
//     )

//     let chapterNumber = 0
//     let pageNumber = 0
//     this.zip.forEach((file) => {
//       if (['html', 'htm', 'xhtml'].includes(file.extension!)) {
//         chapterNumber = chapterNumber + 1

//         const text = this.epubParserUtils.stripTags(
//           file.text!,
//           ['p', 'i', 'u', 's'],
//           true
//         )
//         // const chunksText = utils.chunkString(text, vh * this.size)
//         const split = this.epubParserUtils.splitString(text, vh * this.size)

//         split.forEach((chunk, chunkKey) => {
//           if (chunkKey === 0) {
//             this.tableOfContent.push({
//               id: `ebook-${chapterNumber}`,
//               label: 'chapter ' + chapterNumber,
//               chapter: chapterNumber,
//               page: pageNumber,
//             })
//           }
//           this.pages.push({
//             text: chunk,
//             number: pageNumber + 1,
//             chapter: chapterNumber,
//             ncx: this.getFileNameNcx(file.name),
//           })
//           pageNumber++
//         })
//       }
//     })

//     return this.pages
//   }

//   /**
//    * Reorder pages from `tableOfContents`.
//    */
//   private orderPagesFromToc = () => {
//     const list: Page[] = []

//     this.tableOfContent.forEach((item) => {
//       const ncxPages = this.pages.filter((page) => page.ncx === item.content)
//       list.push(...ncxPages)
//     })
//     this.pages = list
//     this.pages.unshift(this.cover)
//   }

//   /**
//    * Get table of content from `toc.ncx` and improve `tableOfContent`.
//    */
//   private setTableOfContents = () => {
//     const parser = new DOMParser()
//     const xmlDoc = parser.parseFromString(this.zipNcx.text!, 'text/xml')
//     const navMap = xmlDoc.getElementsByTagName('navMap')[0]
//     const navPoints = navMap.getElementsByTagName('navPoint')

//     let list = Object.values(navPoints)
//     list = list.filter(
//       (value, index, self) => index === self.findIndex((t) => t.id === value.id)
//     )

//     if (
//       list.length === this.tableOfContent.length ||
//       list.length === this.tableOfContent.length - 1 ||
//       list.length === this.tableOfContent.length + 1
//     ) {
//       let i = 0
//       for (const navPoint of list) {
//         const navLabel = navPoint.getElementsByTagName('navLabel')[0]
//         const title = navLabel.getElementsByTagName('text')[0]
//           .textContent as string
//         const content = navPoint
//           .getElementsByTagName('content')[0]
//           .getAttribute('src')

//         const contentName = this.getFileNameNcx(content!)

//         if (this.tableOfContent.length && this.tableOfContent[i]) {
//           this.tableOfContent[i].label = title
//           this.tableOfContent[i].content = contentName
//         }
//         i++
//       }
//       this.orderPagesFromToc()
//     }

//     return this.tableOfContent
//   }

//   getFileNameNcx = (content?: string) => {
//     let contentSpine = ''
//     if (content) {
//       const contentFile = content.split('/')
//       const contentExtSplit = contentFile[contentFile.length - 1]
//       contentSpine = contentExtSplit.replace('.', '-')
//     }

//     return contentSpine.includes('titlepage') ? 'titlepage' : contentSpine
//   }

//   /**
//    * Parse `content.opf` from `zipOpf`.
//    */
//   private getOpfPackage = () => {
//     const parser = new DOMParser()
//     const xmlDoc = parser.parseFromString(this.zipOpf.text!, 'text/xml')

//     return xmlDoc.getElementsByTagName('package')[0]
//   }

//   /**
//    * Extract `spine` from `content.opf`.
//    */
//   private setSpine() {
//     const spine = this.getOpfPackage().getElementsByTagName('spine')[0]
//     const itemRefs = spine.getElementsByTagName('itemref')

//     Object.values(itemRefs).every((itemRef) =>
//       this.spine.push(itemRef.getAttribute('idref')!)
//     )

//     return this.spine
//   }

//   /**
//    * Get cover file from `content.opf`.
//    */
//   private setCover() {
//     const manifest = this.getOpfPackage().getElementsByTagName('manifest')[0]
//     const items = manifest.getElementsByTagName('item')

//     const itemsList: Element[] = []
//     for (const item of Object.values(items)) {
//       if (item.getAttribute('media-type') === 'image/jpeg') {
//         const id = item.getAttribute('id') as string
//         const href = item.getAttribute('href') as string
//         const regex = new RegExp('cover*', 'g')
//         if (regex.test(id) || regex.test(href)) {
//           itemsList.push(item)
//         }
//       }
//     }
//     if (itemsList[0]) {
//       const cover = itemsList[0]
//       const name = cover.getAttribute('href')
//       this.zip.forEach((file) => {
//         if (file.name === name) {
//           this.cover = {
//             name: file.name,
//             isImage: true,
//             src: URL.createObjectURL(file.blob!),
//           }
//           this.pages.unshift(this.cover)
//         }
//       })
//     }

//     return this.cover
//   }

//   /**
//    * Change page effect.
//    */
//   private changePage = (newPage: number): Progress => {
//     if (newPage >= 0 && this.pages.length - 1 >= newPage) {
//       this.currentPageIndex = newPage
//       this.currentPage = this.pages[this.currentPageIndex]
//     }

//     return {
//       number: this.currentPageIndex,
//       page: this.currentPage,
//     }
//   }

//   /**
//    * Get first page.
//    */
//   first = () => {
//     return this.changePage(0)
//   }

//   /**
//    * Get last page.
//    */
//   last = () => {
//     return this.changePage(this.pages.length - 1)
//   }

//   /**
//    * Get previous page.
//    */
//   previous = (): Progress => {
//     return this.changePage(this.currentPageIndex - 1)
//   }

//   /**
//    * Get next page.
//    */
//   next = (): Progress => {
//     return this.changePage(this.currentPageIndex + 1)
//   }

//   /**
//    * Get `page`.
//    */
//   jump = (page: number): Progress => {
//     // @ts-ignore
//     this.currentPageIndex = parseInt(page)
//     this.currentPage = this.pages[this.currentPageIndex]

//     return {
//       number: this.currentPageIndex,
//       page: this.currentPage,
//     }
//   }
// }
