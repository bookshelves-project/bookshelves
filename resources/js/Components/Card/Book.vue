<script lang="ts" setup>
interface Props {
  book: App.Models.Book
  square?: boolean
  carousel?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  square: false,
})

const title = computed(() => {
  let title = `${props.book.title}`
  if (props.book.authors_names)
    title = `${title} by ${props.book.authors_names}`
  if (props.book.serie)
    title = `${props.book.serie.title} #${props.book.volume_pad} - ${title}`

  return title
})
</script>

<template>
  <CardModel
    :square="square"
    :cover="square ? book.cover_square : book.cover_thumbnail"
    :title="title"
    :href="$route('books.show', { library: book.library?.slug, book: book.slug })"
    :carousel="carousel"
    :color="book.cover_color"
  >
    <template #title>
      {{ book.title }}
    </template>
    <template
      v-if="book.serie"
      #subtitle
    >
      {{ book.serie?.title }} #{{ book.volume_pad }}
    </template>
    <template #extra>
      {{ book.authors_names }}
    </template>
    <template
      v-if="book.language"
      #topLeft
    >
      {{ book.language.name }}
    </template>
    <template
      v-if="book.library"
      #topRight
    >
      {{ book.library.type_label }}
    </template>
  </CardModel>
</template>
