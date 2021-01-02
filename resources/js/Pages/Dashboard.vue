<template>
  <app-layout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="container grid grid-cols-3 gap-4 mx-auto mt-8 mb-5">
      <book-card v-for="book in books" :key="book.id" :book="book"></book-card>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import BookCard from '../components/book-card.vue'

export default {
  components: {
    AppLayout,
    BookCard,
  },
  data() {
    return {
      books: this.$page.books.data,
    }
  },
}
</script>
