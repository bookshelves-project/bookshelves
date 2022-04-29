import Alpine from 'alpinejs'

const webreader: IWebreader = {
  isLoading: true,
  bookData: {} as BookData,
  configKey: 'webreader_comic_config',

  gridIsAvailable: false,
  grid: [] as GridImg[],
  showGrid: false,

  bookIsReady: false,
  showNavigation: true,
  navigationIsLock: true,

  sizeFull: false,
  sizeLarge: false,
  sizeScreen: true,
  currentSize: 'sizeScreen' as Size,

  isFullscreen: false,
  informationEnabled: false,

  currentPage: 0,
  lastPage: 0,
  progress: 0,

  commands: [],
  imagesList: [],

  init() {
    console.log('initialize webreader')
  },
  ready() {
    this.isLoading = !this.isLoading
  },
}

export default webreader
