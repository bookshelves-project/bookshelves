<script lang="ts" setup>
interface Props {
  serie: App.Models.Serie
  square?: boolean
  carousel?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  square: false,
})

const title = computed(() => {
  let title = `${props.serie.title}`
  if (props.serie.authors_names)
    title = `${title} by ${props.serie.authors_names}`
  if (props.serie.books_count)
    title = `${title} (${props.serie.books_count} books)`

  return title
})
</script>

<template>
  <CardModel
    :square="square"
    :cover="serie.cover_thumbnail"
    :title="title"
    :href="$route('series.show', { library: serie.library?.slug, serie: serie.slug })"
    :carousel="carousel"
    :color="serie.cover_color"
  >
    <template #title>
      {{ serie.title }}
    </template>
    <template
      v-if="serie.books_count"
      #subtitle
    >
      {{ serie.books_count }} books
    </template>
    <template #extra>
      {{ serie.authors_names }}
    </template>
    <template
      v-if="serie.language"
      #topLeft
    >
      {{ serie.language.name }}
    </template>
    <template
      v-if="serie.library"
      #topRight
    >
      {{ serie.library.type_label }}
    </template>
  </CardModel>
</template>
