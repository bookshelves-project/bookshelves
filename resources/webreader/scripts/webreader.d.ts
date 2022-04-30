interface IWebreader {
  $nextTick: (callback: (value: any) => void) => void

  isLoading: boolean
  bookData: BookData
  configKey: string

  gridIsAvailable: boolean
  grid: GridImg[]
  showGrid: boolean
  toc: NavItem[]

  sidebarWrapperIsEnabled: boolean
  sidebarBackdropIsEnabled: boolean
  sidebarIsEnabled: boolean

  bookIsDownloaded: boolean
  bookIsReady: boolean
  showNavigation: boolean
  navigationIsLock: boolean

  sizeFull: boolean
  sizeLarge: boolean
  sizeScreen: boolean
  currentSize: Size

  isFullscreen: boolean
  informationEnabled: boolean
  tutorialIsEnabled: boolean

  currentPage: number
  lastPage: number
  progress: number
  pageRange: number

  commands: Command[]
  imagesList: ComicImage[]
  navigationOptions: NavigationOptions

  init: () => void

  disableTutorial: () => void
  toggleMenu: () => void
  setEvents: () => void
  setCommands: () => void

  fullscreen: () => void
  fullscreenExit: () => void
  switchSize: (size: Size) => void
  lockMenu: () => void
  deleteProgression: () => void

  saveConfig: () => void
  getConfig: () => StorageConfig

  toggleSidebar: () => void
  openSidebar: () => void
  closeSidebar: () => void
}

interface IBook {
  $store: {
    webreader: IWebreader
  }
  $watch: (value: string, callback: (value: any) => void) => void

  initialize: (data: string) => void

  createBook: () => Promise<void>
  setReader: () => void
  setEvents: () => void

  first: () => void
  last: () => void
  previous: () => void
  next: () => void

  displayGrid?: () => void
  setGrid?: () => Promise<void>

  changePageRange: () => void
}

interface Events {
  $store: {
    webreader: IWebreader
  }
  $watch: (value: string, callback: (value: any) => void) => void
  init: () => void
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

interface NavItem {
  id: string
  href: string
  label: string
  subitems?: Array<NavItem>
  parent?: string
}

interface NavigationOptions {
  fullscreen: boolean
  grid: boolean
  sidebar: boolean
  first: boolean
  last: boolean
  previous: boolean
  next: boolean
  sizeable: boolean
  information: boolean
}
interface AlpineRefs {
  reader: HTMLImageElement
  tocElement?: HTMLElement
}
