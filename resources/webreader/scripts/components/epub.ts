import { epubjsInit } from './epubjs/methods'

const epubjs = () => ({
  init() {
    // @ts-ignore
    return epubjsInit(this.$refs)
  },
})

export default epubjs
