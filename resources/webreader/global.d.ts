import type { Alpine as AlpineType } from '@types/alpinejs'

interface Window {
  Alpine: AlpineType
}

declare module 'alpinejs'

import EpubParser from './library/epub-parser'

export {}

/**
 * From https://bobbyhadz.com/blog/typescript-make-types-global
 */
declare global {
  interface IWebreader {
    $nextTick: (callback: (value: any) => void) => void

    isLoading: boolean
    bookData: BookData
    configKey: string

    gridIsAvailable: boolean
    grid: GridImg[]
    showGrid: boolean
    toc: EpubParserNavItem[] | NavItem[]

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
    chapter: number
    lastPage: number
    progress: number
    pageRange: number

    commands: Command[]
    imagesList: ComicImage[]
    navigationOptions: NavigationOptions

    init: () => void

    disableTutorial: () => void
    toggleMenu: () => void
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

    changePageRange: () => void

    displayGrid?: () => void
    setGrid?: () => Promise<void>
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

  declare type Size = 'sizeFull' | 'sizeLarge' | 'sizeScreen'

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
  interface EpubParserNavItem {
    id?: string
    label?: string
    chapter?: number

    page?: number
    content?: string
    contentName?: string
    contentExtension?: string
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

  interface BlobFile {
    name: string
    url?: string
    iframe?: HTMLIFrameElement
  }
  interface Page {
    text?: string
    src?: string
    number?: number
    chapter?: number
    ncx?: string
  }
  interface Chapter {
    name: string
    pages: Page[]
  }

  interface Progress {
    number: number
    page: Page
  }

  interface ZipFile {
    name?: string
    file?: JSZipObject
    extension?: string
    blob?: Blob
    text?: string
    isImage? = false
    src?: string
  }
}
