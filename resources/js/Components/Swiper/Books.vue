<script lang="ts" setup>
defineProps<{
  books?: App.Models.Book[]
  title?: string
  padding?: boolean
  square?: boolean
  link?: string
  ready: boolean
}>()
</script>

<template>
  <AppCarousel
    v-if="books && books.length"
    :title="title"
    :url="link"
    :padding="padding"
    :ready="ready"
  >
    <template
      v-for="book in books"
      :key="book.id"
    >
      <CardBook
        :book="book"
        :square="square"
        class="w-44"
      />
    </template>
  </AppCarousel>
</template>
