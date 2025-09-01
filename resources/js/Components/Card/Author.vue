<script lang="ts" setup>
import { useFetch } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  author: App.Models.Author
}>()

const booksCount = ref<number>()
const seriesCount = ref<number>()

booksCount.value = props.author.books_count
seriesCount.value = props.author.series_count

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
      v-if="booksCount || seriesCount"
      #extra
    >
      {{ booksCount ?? 0 }} books, {{ seriesCount ?? 0 }} series
    </template>
  </CardModel>
</template>
