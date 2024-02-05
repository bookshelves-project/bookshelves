<script lang="ts" setup>
defineProps<{
  books?: App.Models.Book[]
  title?: string
  url?: string
  padding?: boolean
}>()
</script>

<template>
  <AppCarousel
    v-if="books && books.length"
    :title="title"
    :url="url"
    :padding="padding"
  >
    <template
      v-for="book in books"
      :key="book.id"
    >
      <CardBook
        :book="book"
        class="w-44"
      />
    </template>
  </AppCarousel>
</template>
