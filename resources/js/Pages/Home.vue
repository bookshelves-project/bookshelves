<script lang="ts" setup>
const swipers: {
  route?: string
  endpoint?: string
  title: string
  type: 'book' | 'serie'
  square?: boolean
}[] = [
  {
    route: '/api/books/latest/audiobook',
    title: 'Audiobooks recently added',
    type: 'book',
    square: true,
  },
  {
    route: '/api/books/latest/book',
    title: 'eBooks recently added',
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
]
</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <div class="py-6 space-y-12">
      <SwiperHome
        v-for="swiper in swipers"
        :key="swiper.route"
        :route="swiper.route"
        :title="swiper.title"
        :type="swiper.type"
        :square="swiper.square"
      />
    </div>
  </App>
</template>
