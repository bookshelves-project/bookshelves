import { useFetch } from '@kiwilan/typescriptable-laravel'
import { defineStore } from 'pinia'

export interface Swiper {
  route?: string
  key: string
  title: string
  type: 'book' | 'serie'
  square?: boolean
  link: string
  items: App.Models.Book[] | App.Models.Serie[]
}

const libraries = ref<App.Models.Library[]>([])
const swipers = ref<Swiper[]>([])
const items = ref<any>({})

export const useHomeSwiperStore = defineStore('home-swiper', () => {
  async function fetchSwipers() {
    if (swipers.value.length > 0) {
      return swipers.value
    }

    const libraries = await fetchLibraries()
    libraries?.forEach((library) => {
      const route = `/api/books/latest/${library.slug}`
      swipers.value.push({
        route,
        key: route.replaceAll('/', '-').substring(1),
        title: `${library.name} recently added`,
        type: 'book',
        square: library.type === 'audiobook',
        link: `/libraries/${library.slug}?limit=50&sort=-added_at`,
        items: [],
      })
    })

    for (const swiper of swipers.value) {
      const models = await fetchLibrary(swiper)
      swiper.items = models
    }

    return swipers.value
  }

  async function fetchLibrary(swiper: Swiper) {
    const { http } = useFetch()

    if (!swiper.route) {
      console.warn('SwiperHome: No route')
      return
    }

    if (itemExists(swiper.key)) {
      return getItem(swiper.key)
    }

    const res = await http.get(swiper.route)
    const body = await res.getBody<{ data: App.Models.Book[] | App.Models.Serie[] }>()

    if (!body?.data) {
      console.error('SwiperHome: No response')
      return
    }

    addItem(swiper.key, body?.data)

    return body.data
  }

  async function fetchLibraries() {
    if (libraries.value.length === 0) {
      const { laravel } = useFetch()
      const res = await laravel.get('api.libraries.index')
      const body = await res.getBody<{ data: App.Models.Library[] }>()

      if (!body?.data) {
        return
      }

      libraries.value = body.data
    }

    return libraries.value
  }

  function addItem(key?: string, data?: any) {
    if (!items.value) {
      items.value = {}
    }

    if (!key || !data) {
      return
    }

    items.value[key] = data
  }

  function itemExists(key?: string) {
    if (!key) {
      return false
    }

    return items.value && items.value[key]
  }

  function getItem(key?: string) {
    if (!key) {
      return
    }

    return items.value && items.value[key]
  }

  return {
    swipers,
    fetchSwipers,
  }
})
