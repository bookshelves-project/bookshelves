interface IWebreader {
  isLoading: boolean
  bookData: BookData
  configKey: string

  gridIsAvailable: boolean
  grid: GridImg[]
  showGrid: boolean

  bookIsReady: boolean
  showNavigation: boolean
  navigationIsLock: boolean

  sizeFull: boolean
  sizeLarge: boolean
  sizeScreen: boolean
  currentSize: Size

  isFullscreen: boolean
  informationEnabled: boolean

  currentPage: number
  lastPage: number
  progress: number

  commands: Command[]
  imagesList: ComicImage[]

  init?: () => void
  ready?: () => void
}

interface IBook {
  $store: {
    webreader: IWebreader
  }
  $watch: (value: string, callback: (value: any) => void) => void
  init?: () => void
  initialize?: (data: string) => void
  checkIsReady?: () => void
  createBook: () => void
  setImage: () => void
  first: () => void
  last: () => void
  previous: () => void
  next: () => void
  switchSize: (size: Size) => void
  fullscreen: () => void
  fullscreenExit: () => void
  lock: () => void
  deleteProgression: () => void
  displayGrid: () => void
  getGrid: () => void
  saveConfig: () => void
  getConfig: () => void
  events: () => void
  commands: () => void
}

interface ComicImage {
  index: number
  name: string
  read(): Promise<ArrayBuffer>
}

type Size = 'sizeFull' | 'sizeLarge' | 'sizeScreen'

interface BookData {
  title: string
  filename: string
  url: string
  download: string
  format: string
  size_human: string
}

interface StorageConfig {
  page?: string
  size?: Size
  locked?: boolean
}

interface Command {
  key?: string[]
  label?: string
}

interface GridImg {
  name: string
  img?: string
}
