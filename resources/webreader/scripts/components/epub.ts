import { epubjsInit } from './epubjs/methods'

const epubjs = () => ({
  epubjsInit() {
    return epubjsInit(this.$refs)
  },
})

export default epubjs
