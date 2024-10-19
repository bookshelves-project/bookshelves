import type { Ebook } from '@/Types/foliate.js'

enum FoliateType {
  zip = 'zip',
  pdf = 'pdf',
  mobi = 'mobi',
  fb2 = 'fb2',
  epub = 'epub',
  cbz = 'cbz',
  fbz = 'fbz',
  unknown = 'unknown',
}

export class FoliateEngine {
  private constructor(
    private file: File,
    private headers: Headers = new Headers(),
    private contentType?: string | null,
    private contentDisposition?: string | null,
    private type: FoliateType = FoliateType.unknown,
    private isZip: boolean = false,
    private isPdf: boolean = false,
    private isMobi: boolean = false,
    private isFb2: boolean = false,
    private isEpub: boolean = false,
    private isCbz: boolean = false,
    private isFbz: boolean = false,
    private ebook: Ebook | undefined = undefined,
  ) {}

  /**
   * Create a new FoliateEngine instance
   *
   * @param url - The URL of the file to load
   *
   * @returns A new FoliateEngine instance
   */
  public static async make(url: string | undefined): Promise<FoliateEngine> {
    if (!url) {
      throw new Error('URL is not defined')
    }

    const response = await FoliateEngine.download(url)
    const file = new File([await response.blob()], new URL(response.url).pathname)
    const type = new FoliateEngine(file, response.headers)

    type.contentType = response.headers.get('content-type')
    type.contentDisposition = response.headers.get('content-disposition')

    const ebook = await type.detect()
    console.log(type)
    if (!ebook)
      throw new Error('File type not supported')

    return type
  }

  /**
   * Detect the type of the file and create the appropriate Ebook instance
   *
   * - ZIP: EPUB, CBZ, FBZ
   * - PDF
   * - MOBI
   * - FB2
   */
  private async detect() {
    this.isZip = await this.isZipType()
    if (this.isZip) {
      this.type = FoliateType.zip
      return await this.handleZip()
    }

    this.isPdf = await this.isPDFType()
    if (this.isPdf) {
      this.type = FoliateType.pdf
      const { makePDF } = await import('./library/pdf.js')
      return await makePDF()
    }

    const { isMOBI, MOBI } = await import('./library/mobi.js')
    this.isMobi = await isMOBI(this.file)
    if (this.isMobi) {
      this.type = FoliateType.mobi
      const fflate = await import('./library/vendor/fflate.js')
      return await new MOBI({ unzlib: fflate.unzlibSync }).open(this.file)
    }

    this.isFb2 = this.isFB2Type()
    if (this.isFb2) {
      this.type = FoliateType.fb2
      const { makeFB2 } = await import('./library/fb2.js')
      return await makeFB2(this.file)
    }

    return undefined
  }

  /**
   * Handle ZIP files
   */
  private async handleZip() {
    const loader = await this.makeZipLoader() as any

    this.isCbz = this.isCBZType()
    if (this.isCbz) {
      this.type = FoliateType.cbz
      const { makeComicBook } = await import('./library/comic-book.js')
      const comic = makeComicBook(loader)

      return comic
    }

    this.isFbz = this.isFBZType()
    if (this.isFbz) {
      this.type = FoliateType.fbz
      const { makeFB2 } = await import('./library/fb2.js')
      const { entries } = loader
      const entry = entries.find((entry: any) => entry.filename.endsWith('.fb2'))
      const blob = await loader.loadBlob((entry ?? entries[0]).filename)
      const fbz = await makeFB2(blob)

      return fbz
    }

    this.isEpub = this.isEpubType()
    if (this.isEpub) {
      this.type = FoliateType.epub
      const { EPUB } = await import('./library/epub.js')

      return await new EPUB(loader).init() as unknown as Ebook
    }

    return undefined
  }

  /**
   * Check if the file is a ZIP archive
   */
  private async isZipType(): Promise<boolean> {
    const arr = new Uint8Array(await this.file.slice(0, 4).arrayBuffer())
    return arr[0] === 0x50 && arr[1] === 0x4B && arr[2] === 0x03 && arr[3] === 0x04
  }

  /**
   * Check if the file is a PDF
   */
  private async isPDFType(): Promise<boolean> {
    const arr = new Uint8Array(await this.file.slice(0, 5).arrayBuffer())
    return arr[0] === 0x25
      && arr[1] === 0x50 && arr[2] === 0x44 && arr[3] === 0x46
      && arr[4] === 0x2D
  }

  /**
   * Check if ZIP archive is a CBZ
   *
   * - `content-type`: `application/vnd.comicbook+zip`
   * - `content-disposition`: `attachment;filename=sample.cbz`
   */
  private isCBZType(): boolean {
    if (this.contentType === 'application/vnd.comicbook+zip') {
      return true
    }

    if (this.contentDisposition) {
      return this.contentDisposition.endsWith('.cbz')
    }

    return false
  }

  /**
   * Check if ZIP archive is a FBZ
   *
   * - `content-type`: `application/x-fictionbook+xml`
   * - `content-disposition`: `attachment;filename=sample.fb2`
   */
  private isFB2Type(): boolean {
    if (this.contentType === 'application/x-fictionbook+xml') {
      return true
    }

    if (this.contentDisposition) {
      return this.contentDisposition.endsWith('.fb2')
    }

    return false
  }

  /**
   * Check if ZIP archive is a FBZ
   *
   * - `content-type`: `application/x-zip-compressed-fb2`
   * - `content-disposition`: `attachment;filename=sample.fb2.zip` or `attachment;filename=sample.fbz`
   */
  private isFBZType(): boolean {
    if (this.contentType === 'application/x-zip-compressed-fb2') {
      return true
    }

    if (this.contentDisposition) {
      return this.contentDisposition.endsWith('.fbz') || this.contentDisposition.endsWith('.fb2.zip')
    }

    return false
  }

  /**
   * Check if ZIP archive is an EPUB
   *
   * - `content-type`: `application/epub+zip`
   * - `content-disposition`: `attachment;filename=sample.epub`
   */
  private isEpubType(): boolean {
    if (this.contentType === 'application/epub+zip') {
      return true
    }

    if (this.contentDisposition) {
      return this.contentDisposition.endsWith('.epub')
    }

    return false
  }

  /**
   * Load the ZIP archive
   */
  private async makeZipLoader() {
    const { configure, ZipReader, BlobReader, TextWriter, BlobWriter } = await import('./library/vendor/zip.js')
    configure({ useWebWorkers: false })

    const reader = new ZipReader(new BlobReader(this.file))
    const entries = await reader.getEntries()
    // @ts-expect-error - TS doesn't know about the private `filename` property
    const map = new Map(entries.map(entry => [entry.filename, entry]))
    // @ts-expect-error - TS doesn't know about the private `getData` method
    const load = (f: any) => (name, ...args) =>
      map.has(name) ? f(map.get(name), ...args) : null

    const loadText = load((entry: any) => entry.getData(new TextWriter()))
    const loadBlob = load((entry: any, type: any) => entry.getData(new BlobWriter(type)))
    // @ts-expect-error - TS doesn't know about the private `uncompressedSize` property
    const getSize = (name: any) => map.get(name)?.uncompressedSize ?? 0

    return { entries, loadText, loadBlob, getSize }
  }

  /**
   * Load the directory
   */
  private async getFileEntries(entry: any): Promise<any[]> {
    return entry.isFile
      ? entry
      : (await Promise.all(Array.from(
          await new Promise<any>((resolve, reject) => entry.createReader()
            .readEntries((entries: any[]) => resolve(entries), (error: any) => reject(error))),
          this.getFileEntries,
        ))).flat()
  }

  /**
   * Load the directory
   */
  private async makeDirectoryLoader() {
    const entries = await this.getFileEntries(this.file)

    const files = await Promise.all(
      entries.map((entry: any) => new Promise((resolve, reject) =>
        entry.file((file: any) => resolve([file, entry.fullPath]), (error: any) => reject(error)))),
    )
    // @ts-expect-error - TS doesn't know about the private `fullPath` property
    const map = new Map(files.map(([file, path]) => [path.replace(`${entry.fullPath}/`, ''), file]))

    const decoder = new TextDecoder()
    const decode = (x: any) => x ? decoder.decode(x) : null
    // @ts-expect-error - TS doesn't know about the private `arrayBuffer` method
    const getBuffer = (name: any) => map.get(name)?.arrayBuffer() ?? null
    const loadText = async (name: any) => decode(await getBuffer(name))
    const loadBlob = (name: any) => map.get(name)
    // @ts-expect-error - TS doesn't know about the private `size` property
    const getSize = (name: any) => map.get(name)?.size ?? 0
    return { loadText, loadBlob, getSize }
  }

  /**
   * Download the file
   */
  private static async download(url: string): Promise<Response> {
    const res = await fetch(url)
    if (!res.ok) {
      throw new Error(`${res.status} ${res.statusText}`)
    }

    return res
  }
}
