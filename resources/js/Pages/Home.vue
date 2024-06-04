<script lang="ts" setup>
import { Head } from '@inertiajs/vue3'
// import { usePage } from '@inertiajs/vue3'

// const { props } = usePage()
// console.log(props.ziggy)
console.log(process.env.NODE_ENV === 'development')
console.log(window)

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
  <Head>
    <title>Your page title</title>
    <meta
      name="description"
      content="Your page description"
    >
  </Head>
  <div>
    bouyah!
  </div>
  <!-- <App
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
        :square="swiper.square"
      />
    </div>
  </App> -->
</template>
