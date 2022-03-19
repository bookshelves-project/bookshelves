import { epubjsInit } from './epubjs/methods'

const epubjs = () => ({
  epubjsInit() {
    // @ts-ignore
    return epubjsInit(this.$refs)
  },
})

export default epubjs
