<script lang="ts" setup>
import { useFoliate } from '@/Composables/useFoliate'

const { book } = defineProps<{
  book: App.Models.Book
}>()

onMounted(async () => {
  const { ebook } = await useFoliate(book.download_link)
})
// console.log(ebook.value)
// console.log(ebook.value?.rendition)
</script>

<template>
  <div>
    home
  </div>
</template>
