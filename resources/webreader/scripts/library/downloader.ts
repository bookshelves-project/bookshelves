export default class Downloader {
  url: string
  filename: string

  downloadStatus = '0'
  loaded = 0
  total = 0
  blob = new Blob()
  file = new File([''], 'filename')

  constructor(url: string, filename: string) {
    this.url = url
    this.filename = filename
  }
  download = async () => {
    const response = await fetch(this.url)

    if (response.body) {
      const reader = response.body.getReader()

      // Step 2: get total length
      const contentLength = +response.headers.get('Content-Length')!
      this.total = contentLength

      const progress = ({ loaded, total }) => {
        this.downloadStatus = Math.round((loaded / total) * 100) + '%'
      }

      // Step 3: read the data
      let receivedLength = 0 // received that many bytes at the moment
      const chunks: Uint8Array[] = [] // array of received binary chunks (comprises the body)
      // eslint-disable-next-line no-constant-condition
      while (true) {
        const { done, value } = await reader.read()

        if (done) {
          break
        }

        chunks.push(value)
        receivedLength += value.length

        this.loaded += value.byteLength
        // const status = `Received ${receivedLength} of ${contentLength}`
        progress({ loaded: this.loaded, total: this.total })
        const element = document.getElementById('downloadStatus')!
        element.textContent = this.downloadStatus
      }

      // Step 4: concatenate chunks into single Uint8Array
      const chunksAll = new Uint8Array(receivedLength) // (4.1)
      let position = 0
      for (const chunk of chunks) {
        chunksAll.set(chunk, position) // (4.2)
        position += chunk.length
      }

      // Step 5: decode into a string
      // const result = new TextDecoder('utf-8').decode(chunksAll)
      this.convert(chunksAll)
    }
  }
  private convert = (uint8Array: Uint8Array) => {
    this.blob = new Blob([new Uint8Array(uint8Array)])
    this.file = new File([this.blob], this.filename)
  }
}

// const contentLength = response.headers.get('content-length')
// const total = parseInt(contentLength!, 10)
// let loaded = 0

// const progress = ({ loaded, total }) => {
//   this.downloadStatus = Math.round((loaded / total) * 100) + '%'
// }
// const res = new Response(
//   new ReadableStream({
//     async start(controller) {
//       if (response.body) {
//         const reader = response.body.getReader()
//         for (;;) {
//           const { done, value } = await reader.read()
//           if (done) break
//           loaded += value.byteLength
//           progress({ loaded, total })
//           controller.enqueue(value)
//         }
//         controller.close()
//       }
//     },
//   })
// )
// const blob = await res.blob()
