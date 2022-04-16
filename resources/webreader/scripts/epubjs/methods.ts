import { Book, Rendition } from 'epubjs'
// import {
//   selectListener,
//   clickListener,
//   swipListener,
//   wheelListener,
//   keyListener,
// } from './listener'
import { EpubThemes, dark, tan, defaultStyle } from './theme'

interface AlpineRefs {
  filePath?: HTMLElement
  loadingMessage?: HTMLElement
  readButton?: HTMLElement
  presentation?: HTMLElement
  reader?: HTMLElement
  pageFirstBtn?: HTMLElement
  pagePrevBtn?: HTMLElement
  sidebarBtn?: HTMLElement
  pageNextBtn?: HTMLElement
  pageLastBtn?: HTMLElement
  pageLeftBtn?: HTMLElement
  pageCenterBtn?: HTMLElement
  pageRightBtn?: HTMLElement
  navigationOnScreen?: HTMLElement
  navigationOnScreenDisableTutoBtn?: HTMLElement
  navigationOnScreenInterface?: HTMLElement
}

let book: Book
let rendition: Rendition
let toc = []
// let progress
// const isReady = false
let refsAlpine: AlpineRefs

const epubjsInit = async (refs) => {
  refsAlpine = refs

  setup()
}

/**
 * Get Book from path
 * Init Book and Rendition
 */
const setup = async () => {
  const filePath = refsAlpine.filePath
  const path = filePath?.textContent

  const info = {
    toc: {},
    lastOpen: 0,
    path,
    highlights: [],
  }
  //   let toc = info.toc;
  info.lastOpen = new Date().getTime()
  //   let buble = $refs.bubleMenu;

  book = new Book(info.path!)
  rendition = new Rendition(book, {
    width: '100%',
    height: '100%',
    // ignoreClass?: string,
    manager: 'default',
    // view?: string | Function | object,
    // flow?: string,
    // layout?: string,
    spread: 'always',
    // minSpreadWidth?: number,
    // stylesheet: '/assets/css/blade/webreader.css',
    // resizeOnOrientationChange?: boolean,
    // script?: string,
    infinite: true,
    // overflow?: string,
    // snap?: boolean | object,
    // defaultDirection?: string,
  })

  await book.ready
  load()
}

/**
 * Load book
 */
const load = () => {
  // let flipPage = () => {
  //   if (direction === "next") nextPage();
  //   else if (direction === "prev") prevPage();
  // };
  // let toggleBuble = () => {
  //   if (event === "cleared") {
  //     // hide buble
  //     buble.hide();
  //     return;
  //   }
  //   buble.setProps(react, text, cfiRange);
  //   isBubleVisible = true;
  // };
  // rendition.on("rendered", (e, iframe) => {
  //   iframe.iframe.contentWindow.focus();
  //   clickListener(iframe.document, rendition, flipPage);
  //   selectListener(iframe.document, rendition, toggleBuble);
  //   swipListener(iframe.document, flipPage);
  //   wheelListener(iframe.document, flipPage);
  //   keyListener(iframe.document, flipPage);
  // });
  // rendition.on("relocated", (location) => {
  //   info.lastCfi = location.start.cfi;
  //   progress = book.locations.percentageFromCfi(location.start.cfi);
  //   sliderValue = Math.floor(progress * 10000) / 100;
  // });
  // let applyStyle = contentStyle(rendition);
  // await rendition.hooks.content.register(applyStyle || {});
  // const meta = book.package.metadata
  // const title = meta.title
  // let titleTag = document.getElementsByTagName("title");
  // titleTag.item(0).textContent = `${title} ${titleTag.item(0).textContent}`;
  // book.locations.load(1)

  refsAlpine.loadingMessage?.remove()

  refsAlpine.readButton?.classList.remove('hidden')
  refsAlpine.readButton?.addEventListener('click', read)
}

/**
 * Attach iframe to HTML, set themes, display iframe
 */
const displayBook = async () => {
  if (refsAlpine.reader) {
    rendition.attachTo(refsAlpine.reader)
    // const cfi = book.locations.cfiFromPercentage(
    //   10 / book.locations.spine.items.length
    // )

    // const params =
    //   URLSearchParams &&
    //   new URLSearchParams(document.location.search.substring(1))
    // const url =
    //   params && params.get('url') && decodeURIComponent(params.get('url'))
    // const currentSectionIndex =
    //   params && params.get('loc') ? params.get('loc') : undefined
    // rendition.display(currentSectionIndex)
    rendition.display(0)

    rendition.themes.registerRules('dark', dark)
    rendition.themes.registerRules('tan', tan)
    rendition.themes.registerRules('default', defaultStyle)

    const theme: EpubThemes = 'defaultStyle'
    rendition.themes.select(theme)

    rendition.start()
  }
}

/**
 * Set TOC
 */
const setOptions = async () => {
  // info.highlights.forEach((cfiRange) => {
  //   rendition.annotations.highlight(cfiRange);
  // });
  // @ts-ignore
  toc = book.navigation.toc
  // let _flattenedToc = (function flatten(items) {
  //   return [].concat(
  //     ...items.map((item) => [item].concat(...flatten(item.children)))
  //   );
  // })(toc);

  // _flattenedToc.sort((a, b) => {
  //   return a.percentage - b.percentage;
  // });
  setToc()
}

function setToc() {
  const tocBlock = document.getElementById('toc')
  toc.forEach((el, key) => {
    // @ts-ignore
    tocBlock.innerHTML += `<li id="${el.id} chapter-${key}" data-chapter="${el.href}" class="toc-item cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white group flex links-center px-2 py-2 text-sm font-medium rounded-md my-1 justify-between">${el.label}</li>`
  })

  const tocItem = document.getElementsByClassName('toc-item')
  for (const index in tocItem) {
    // @ts-ignore
    if (index <= tocItem.length) {
      tocItem[index].addEventListener('click', setChapter)
    }
  }
}

const setChapter = () => {
  // @ts-ignore
  const chapter = this.dataset.chapter
  rendition.display(chapter)
}

const read = () => {
  refsAlpine.presentation?.classList.add('hidden')
  refsAlpine.reader?.classList.remove('hidden')

  refsAlpine.navigationOnScreen?.classList.remove('hidden')

  toggleTutorial()

  refsAlpine.pageFirstBtn?.addEventListener('click', firstPage)
  refsAlpine.pagePrevBtn?.addEventListener('click', prevPage)
  refsAlpine.pageNextBtn?.addEventListener('click', nextPage)
  refsAlpine.pageLastBtn?.addEventListener('click', lastPage)

  refsAlpine.pageLeftBtn?.addEventListener('click', prevPage)
  refsAlpine.pageRightBtn?.addEventListener('click', nextPage)

  refsAlpine.navigationOnScreenDisableTutoBtn?.addEventListener(
    'click',
    () => {
      localStorage.setItem('bookshelves-webreader-tutorial', 'false')
      toggleTutorial()
    },
    false
  )

  book.ready
    .then(() => {
      displayBook()
    })
    .then(() => {
      setOptions()
    })
}

const prevPage = () => {
  rendition.prev()
  console.clear()
}
const nextPage = () => {
  rendition.next()
  console.clear()
}

const firstPage = () => {
  rendition.display(0)
  console.clear()
}
const lastPage = () => {
  // @ts-ignore
  rendition.display(book.spine.spineItems.length - 1)
  console.clear()
}

/**
 * Toggle visual tutorial for user
 */
const toggleTutorial = () => {
  const tutoTextList = document.getElementsByClassName('on-screen-tuto')
  const storage = localStorage.getItem('bookshelves-webreader-tutorial')

  /**
   * Enable tuto
   */
  if (storage === null || storage === 'true') {
    refsAlpine.navigationOnScreenInterface?.classList.add(
      'on-screen-tuto-color'
    )
    Object.keys(tutoTextList).forEach(function (key) {
      const element: HTMLElement = tutoTextList[key]
      element.classList.remove('hidden')
    })

    localStorage.setItem('bookshelves-webreader-tutorial', 'true')
  } else if (storage === 'false') {
    /**
     * Disable tuto
     */
    refsAlpine.navigationOnScreenInterface?.classList.remove(
      'on-screen-tuto-color'
    )
    Object.keys(tutoTextList).forEach(function (key) {
      const element: HTMLElement = tutoTextList[key]
      element.classList.add('hidden')
    })

    localStorage.setItem('bookshelves-webreader-tutorial', 'false')
  }
}

export { epubjsInit }
