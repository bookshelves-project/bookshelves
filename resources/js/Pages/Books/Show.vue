<script lang="ts" setup>
import { useDate } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  book: App.Models.Book
}>()

const { dateString } = useDate()

const titlePage = computed(() => {
  if (props.book.serie)
    return `${props.book.serie.title} #${props.book.volume_pad} - ${props.book.title}`

  return props.book.title
})

function ucfirst(string?: string) {
  if (!string)
    return ''
  return string.charAt(0).toUpperCase() + string.slice(1)
}
</script>

<template>
  <App
    :title="titlePage"
    icon="ereader"
  >
    <ShowContainer
      :model="book"
      :type="ucfirst(book.type)"
      :title="book.title"
      :cover="book.cover_standard"
      :cover-color="book.cover_color"
      :backdrop="book.cover_social"
      :overview="book.description"
      :tags="book.tags"
      :properties="[
        dateString(book.released_on),
        book.page_count ? `${book.page_count} pages` : undefined,
        book.publisher ? `${book.publisher.name}` : undefined,
      ]"
      :badges="[
        book.isbn10 ? `ISBN-10: ${book.isbn10}` : undefined,
        book.isbn13 ? `ISBN-13: ${book.isbn13}` : undefined,
        book.language ? `${book.language.name}` : undefined,
      ]"
    >
      <template #breadcrumbs>
        <Breadcrumbs
          :breadcrumbs="[
            { label: 'Books', route: { name: 'books.index' } },
            { label: `${book.title}`, route: { name: 'books.show', params: { book_slug: book.slug } } },
          ]"
        />
      </template>
      <template #eyebrow>
        <ShowAuthors :authors="book.authors" />
      </template>
      <template
        v-if="book.serie"
        #undertitle
      >
        <ILink
          :href="$route('series.books.show', { serie_slug: book.serie.slug })"
          class="link"
        >
          {{ book.serie.title }}
        </ILink>
        #{{ props.book.volume_pad }}
      </template>
    </ShowContainer>
  </App>
</template>
