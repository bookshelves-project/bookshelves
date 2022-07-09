const webreader: IWebreader = {
  $nextTick: (callback?: (value: any) => void) => {
    //
  },

  isLoading: true,
  bookData: {} as BookData,
  configKey: 'webreader_comic_config',

  gridIsAvailable: false,
  grid: [] as GridImg[],
  showGrid: false,

  sidebarWrapperIsEnabled: false,
  sidebarBackdropIsEnabled: false,
  sidebarIsEnabled: false,
  toc: [] as EpubParserNavItem[] | NavItem[],

  bookIsDownloaded: false,
  bookIsReady: false,
  showNavigation: true,
  navigationIsLock: true,

  sizeFull: false,
  sizeLarge: false,
  sizeScreen: true,
  currentSize: 'sizeScreen' as Size,

  isFullscreen: false,
  informationEnabled: false,
  tutorialIsEnabled: true,

  currentPage: 0,
  chapter: 0,
  lastPage: 0,
  progress: 0,
  pageRange: 0,

  commands: [],
  imagesList: [],

  navigationOptions: {
    fullscreen: true,
    grid: false,
    sidebar: false,
    first: true,
    last: true,
    next: true,
    previous: true,
    sizeable: false,
    information: true,
  } as NavigationOptions,

  init() {
    setTimeout(() => {
      this.setCommands()
    }, 500)
  },

  disableTutorial() {
    this.tutorialIsEnabled = false
    localStorage.setItem('webreader_epub_tutorial', 'false')
  },
  toggleMenu() {
    this.navigationIsLock = !this.navigationIsLock
    this.showNavigation = this.navigationIsLock
  },
  setCommands() {
    const commands: Command[] = [
      this.navigationOptions.fullscreen
        ? {
          key: ['E'],
          label: 'Fullscreen/Exit Fullscreen',
        }
        : {},
      this.navigationOptions.grid
        ? {
          key: ['G'],
          label:
              'Display all pages (this features need some time to loading after init)',
        }
        : {},
      this.navigationOptions.sidebar
        ? {
          key: ['G'],
          label: 'Display sidebar to get chapters',
        }
        : {},
      {
        key: ['↑', '↓', 'Space'],
        label: 'Scroll page',
      },
      {
        key: ['←', 'Left screen part'],
        label: 'Previous page',
      },
      {
        key: ['Alt', '→', 'Right screen part'],
        label: 'Next page',
      },
      this.navigationOptions.sizeable
        ? {
          key: ['F'],
          label: 'Size full width',
        }
        : {},
      this.navigationOptions.sizeable
        ? {
          key: ['L'],
          label: 'Size large',
        }
        : {},
      this.navigationOptions.sizeable
        ? {
          key: ['S'],
          label: 'Size height screen',
        }
        : {},
      this.navigationOptions.information
        ? {
          key: ['I'],
          label: 'Show informations',
        }
        : {},
      {
        key: ['O', 'Middle screen part'],
        label: 'Lock navigation',
      },
    ]
    this.commands = commands
  },

  fullscreen() {
    document.getElementById('fullScreen')?.requestFullscreen()
    this.isFullscreen = true
  },
  fullscreenExit() {
    document.exitFullscreen()
    this.isFullscreen = false
  },
  switchSize(size: Size) {
    this.sizeFull = false
    this.sizeLarge = false
    this.sizeScreen = false
    this[size] = true
    this.currentSize = size

    this.saveConfig()
  },
  lockMenu() {
    this.navigationIsLock = !this.navigationIsLock
    this.showNavigation = this.navigationIsLock

    this.saveConfig()
  },
  deleteProgression() {
    this.currentPage = 0
    this.currentSize = 'sizeScreen'
    this.navigationIsLock = true

    this.saveConfig()
  },

  saveConfig() {
    const config: StorageConfig = {
      size: this.currentSize,
      locked: this.navigationIsLock,
    }
    localStorage.setItem(this.configKey, JSON.stringify(config))
    localStorage.setItem(this.bookData.filename, this.currentPage.toString())
  },
  getConfig(): StorageConfig {
    let config: StorageConfig = {
      size: 'sizeScreen',
      locked: true,
    }
    if (localStorage.getItem(this.configKey) !== null) {
      const storage = localStorage.getItem(this.configKey)!
      config = JSON.parse(storage)
    }
    if (localStorage.getItem(this.bookData.filename) !== null) {
      const currentPage = localStorage.getItem(this.bookData.filename)!
      this.currentPage = parseInt(currentPage)
    }
    this.switchSize(config.size!)
    this.navigationIsLock = config.locked!
    this.showNavigation = config.locked!

    return config
  },

  toggleSidebar() {
    if (this.sidebarWrapperIsEnabled) {
      this.closeSidebar()
    } else {
      this.openSidebar()
    }
  },
  openSidebar() {
    this.sidebarWrapperIsEnabled = true
    setTimeout(() => {
      this.sidebarBackdropIsEnabled = true
      this.sidebarIsEnabled = true
    }, 300)
  },
  closeSidebar() {
    this.sidebarBackdropIsEnabled = false
    this.sidebarIsEnabled = false
    setTimeout(() => {
      this.sidebarWrapperIsEnabled = false
    }, 300)
  },
}

export default webreader
