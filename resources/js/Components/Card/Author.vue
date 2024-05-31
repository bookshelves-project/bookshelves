<script lang="ts" setup>
const props = defineProps<{
  author: App.Models.Author
}>()

const title = computed(() => {
  return `${props.author.name}`
})
</script>

<template>
  <CardModel
    :cover="author.cover_thumbnail"
    :title="title"
    :href="`/authors/${author.slug}`"
    :color="author.cover_color"
    hide-top
  >
    <template #title>
      {{ author.lastname }} {{ author.firstname }}
    </template>
    <template #subtitle>
      {{ author.name }}
    </template>
    <template
      v-if="author.books_count || author.series_count"
      #extra
    >
      {{ author.books_count }} books, {{ author.series_count }} series
    </template>
  </CardModel>
</template>
