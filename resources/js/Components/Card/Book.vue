<script lang="ts" setup>
const props = defineProps<{
  book: App.Models.Book
}>()
console.log(props.book)
</script>

<template>
  <div>
    <img
      class="poster h-64 mx-auto"
      :src="book.cover_thumbnail"
      loading="lazy"
      :alt="book.title"
    >
    <div class="mt-3">
      <p class="line-clamp-2 text-center">
        {{ book.title }}
      </p>
    </div>
  </div>
</template>
