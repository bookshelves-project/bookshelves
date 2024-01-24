<script lang="ts" setup>
defineProps<{
  books: App.Models.Book[]
}>()
</script>

<template>
  <App>
    <section class="main-container video-list">
      <CardBook
        v-for="book in books"
        :key="book.id"
        :book="book"
      />
    </section>
  </App>
</template>
