<script lang="ts" setup>
import { useFetch } from '@kiwilan/typescriptable-laravel'

const { laravel } = useFetch()
const swipers = ref<{
  route?: string
  endpoint?: string
  title: string
  type: 'book' | 'serie'
  square?: boolean
  link: string
}[]>([])

async function fetchLibraries() {
  const res = await laravel.get('api.libraries.index')
  const body = await res.getBody<{ data: App.Models.Library[] }>()

  return body?.data
}

async function parseLibraries() {
  const libraries = await fetchLibraries()
  if (libraries) {
    swipers.value = libraries.map(library => ({
      route: `/api/books/latest/${library.slug}`,
      title: `${library.name} recently added`,
      type: 'book',
      square: library.type === 'audiobook',
      link: `/libraries/${library.slug}?limit=50&sort=-added_at`,
    }))
  }
}

onMounted(() => {
  parseLibraries()
})
</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <div class="py-6 space-y-6">
      <SwiperHome
        v-for="swiper in swipers"
        :key="swiper.route"
        :route="swiper.route"
        :title="swiper.title"
        :type="swiper.type"
        :square="swiper.square"
        :link="swiper.link"
      />
    </div>
  </App>
</template>
