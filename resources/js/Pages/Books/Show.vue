<script lang="ts" setup>
import { useDate, useFetch } from '@kiwilan/typescriptable-laravel'
import type { Entity } from '@/Types'
import { useUtils } from '@/Composables/useUtils'

const props = defineProps<{
  book: App.Models.Book
  square?: boolean
}>()

const size = ref<string>()
const related = ref<Entity[]>()
const extension = ref<string>()

const { laravel } = useFetch()
const { bytesToHuman, getSize } = useUtils()
const { dateString } = useDate()

const titlePage = computed(() => {
  if (props.book.serie)
    return `${props.book.serie.title} #${props.book.volume_pad} - ${props.book.title} by ${props.book.authors_names}`

  return `${props.book.title} by ${props.book.authors_names}`
})

async function getRelatedBooks(): Promise<Entity[]> {
  const response = await laravel.get('api.books.related', { book: props.book.slug })
  return (await response.json()).data
}

onMounted(async () => {
  const api = await getSize('book', props.book.id)
  size.value = bytesToHuman(api.size)
  extension.value = api.extension

  related.value = await getRelatedBooks()
})
</script>

<template>
  <App
    :title="titlePage"
    :description="book.description"
    :image="book.cover_social"
    :color="book.cover_color"
    icon="ereader"
  >
    <ShowContainer
      :model="book"
      :library="book.library"
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
      :download="{
        url: book.download_link,
        size,
        extension,
      }"
      :breadcrumbs="[
        { label: book.library?.name, route: { name: 'home' } },
        { label: `${book.title}`, route: { name: 'books.show', params: { library: book.library?.slug, book: book.slug } } },
      ]"
      :square="book.library?.type === 'audiobook'"
    >
      <template #eyebrow>
        <ShowAuthors :authors="book.authors" />
      </template>
      <template
        v-if="book.serie"
        #undertitle
      >
        <ILink
          :href="$route('series.show', { library: book.library?.slug, serie: book.serie?.slug })"
          class="link"
        >
          {{ book.serie.title }}
        </ILink>
        #{{ props.book.volume_pad }}
      </template>
      <template #swipers>
        <AppCarousel
          v-if="book.serie"
          :title="`${book.serie?.title} series`"
          :url="$route('series.show', { library: book.library?.slug, serie: book.serie?.slug })"
        >
          <CardBook
            v-for="b in book.serie?.books"
            :key="b.id"
            :book="b"
            :square="square"
            carousel
            class="w-56"
          />
        </AppCarousel>
        <AppCarousel
          v-if="related?.length"
          :title="`${book.title} related`"
        >
          <CardEntity
            v-for="r in related"
            :key="r.slug"
            :entity="r"
            :square="square"
            carousel
            class="w-56"
          />
        </AppCarousel>
      </template>
    </ShowContainer>
  </App>
</template>
