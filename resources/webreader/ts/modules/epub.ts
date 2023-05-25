import { Book } from 'epubjs'
import type { AlpineComponent } from 'alpinejs'

/**
 * epub.js module
 */
function epub(): AlpineComponent<{
  // value: string
  copy: boolean
  // secureContext: () => Promise<void>
  // unsecureContext: () => Promise<void>
  // clipboard: () => Promise<void>
}> {
  return {
    copy: false,

    async boot(url: string) {
      const book = new Book()
      console.log(book)

      // console.log(await epub.loadContainer(url))

      // const render = book.renderTo('epub-render')
      // console.log(render)
    },
  }
}

export default epub
