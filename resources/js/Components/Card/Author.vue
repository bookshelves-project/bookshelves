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

async function fetchItems() {
  if (props.author.books_count && props.author.series_count) {
    booksCount.value = props.author.books_count
    seriesCount.value = props.author.series_count
    return
  }

  const { laravel } = useFetch()
  const response = await laravel.get('api.authors.counts', { author: props.author.slug })
  const body = await response.getBody<{
    data: {
      books: number
      series: number
    }
  }>()

  booksCount.value = body?.data.books
  seriesCount.value = body?.data.series
}

onMounted(() => {
  fetchItems()
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
    <template #extra>
      {{ booksCount ?? 0 }} books, {{ seriesCount ?? 0 }} series
    </template>
  </CardModel>
</template>
