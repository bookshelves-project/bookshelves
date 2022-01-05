<template>
  <div>
    Login

    {{ laravel }}
    <div v-for="(book, id) in books.data" :key="id">
      {{ book.title }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { PropType } from 'vue'
import { Book } from '../../types/book'
import { Model } from '../../types/model'
import { PaginatedData } from '@/types/paginated-data'

const props = defineProps({
  laravel: String,
  books: {
    type: Object as PropType<PaginatedData<Book>>,
    required: true,
  },
  // source: {
  //   type: Object as PropType<PaginatedData<Model>>,
  //   required: true,
  // },
})
console.log('props')
</script>
