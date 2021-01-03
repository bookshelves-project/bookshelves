<template>
  <div>
    <div
      class="container grid grid-cols-1 gap-4 mx-auto mt-8 mb-5 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6"
    >
      <book-card v-for="book in books" :key="book.id" :book="book"></book-card>
    </div>
  </div>
</template>

<script>
import BookCard from '../components/book-card.vue'

export default {
  name: 'Home',
  components: {
    BookCard,
  },
  data() {
    return {
      books: this.$page.books.data,
    }
  },
}
</script>
