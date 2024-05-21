<script lang="ts" setup>
// import { usePage } from '@inertiajs/vue3'

// const { props } = usePage()
// console.log(props.ziggy)

const swipers: {
  route?: string
  endpoint?: string
  title: string
  type: 'book' | 'serie'
}[] = [
  {
    route: '/api/books/latest/book',
    title: 'eBooks recently added',
    type: 'book',
  },
  {
    route: '/api/books/latest/audiobook',
    title: 'Audiobooks recently added',
    type: 'book',
  },
  {
    route: '/api/books/latest/comic',
    title: 'Comics recently added',
    type: 'book',
  },
  {
    route: '/api/books/latest/manga',
    title: 'Mangas recently added',
    type: 'book',
  },
  {
    route: '/api/series/latest/book',
    title: 'Series eBooks recently added',
    type: 'serie',
  },
  {
    route: '/api/series/latest/audiobook',
    title: 'Series audiobooks recently added',
    type: 'serie',
  },
  {
    route: '/api/series/latest/comic',
    title: 'Series comics recently added',
    type: 'serie',
  },
  {
    route: '/api/series/latest/manga',
    title: 'Series mangas recently added',
    type: 'serie',
  },
]
</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <div class="pt-10 space-y-6">
      <SwiperHome
        v-for="swiper in swipers"
        :key="swiper.route"
        :route="swiper.route"
        :title="swiper.title"
        :type="swiper.type"
      />
    </div>
  </App>
</template>
