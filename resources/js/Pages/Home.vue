<script lang="ts" setup>
defineProps<{
  books: App.Models.Book[]
}>()
</script>

<template>
  <App>
    home
    <section class="main-container grid grid-cols-5 gap-6">
      <CardBook
        v-for="book in books"
        :key="book.id"
        :book="book"
      />
    </section>
  </App>
</template>
