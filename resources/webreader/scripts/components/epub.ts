import { initBook } from './epubjs/methods'

const epubjs = () => ({
  initBook() {
    return initBook(this.$refs)
  },
})

export default epubjs
