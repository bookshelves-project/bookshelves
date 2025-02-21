<script lang="ts" setup>
import type { Entity } from '@/Types'
import { useDownload } from '@/Composables/useDownload'
import { useUtils } from '@/Composables/useUtils'
import { useDate, useFetch } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  book: App.Models.Book
  square?: boolean
}>()

const size = ref<string>()
const related = ref<Entity[]>()
const extension = ref<string>()
const breadcrumbs = ref<any[]>([])

const { laravel } = useFetch()
const { bytesToHuman, getSize } = useUtils()
const { formatDate } = useDate()

function setBreadcrumbs() {
  breadcrumbs.value = [
    { label: props.book.library?.name, route: { name: 'libraries.show', params: { library: props.book.library?.slug } } },

  ]

  if (props.book.serie) {
    breadcrumbs.value.push({
      label: props.book.serie.title,
      route: { name: 'series.show', params: { library: props.book.library?.slug, serie: props.book.serie.slug } },
    })
  }

  breadcrumbs.value.push({ label: `${props.book.title}`, route: { name: 'books.show', params: { library: props.book.library?.slug, book: props.book.slug } } })
}
setBreadcrumbs()

const titlePage = computed(() => {
  if (props.book.serie)
    return `${props.book.serie.title} #${props.book.volume_pad} - ${props.book.title} by ${props.book.authors_names}`

  return `${props.book.title} by ${props.book.authors_names}`
})

async function getRelatedBooks(): Promise<Entity[] | undefined> {
  const response = await laravel.get('api.books.related', { book: props.book.slug })
  const body = await response.getBody<{
    data: Entity[]
  }>()

  return body?.data
}

onMounted(async () => {
  const api = await getSize('book', props.book.id)
  size.value = bytesToHuman(api?.size)
  extension.value = api?.extension

  related.value = await getRelatedBooks()
})
</script>

<template>
  <App
    :title="titlePage"
    :description="book.description"
    :image="book.cover_social"
    :color="book.cover_color"
    :icon="book.format_icon as SvgName"
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
        book.released_on ? `Released on ${formatDate(book.released_on)}` : undefined,
        book.publisher ? `Published by ${book.publisher.name}` : undefined,
        book.format === 'audio' ? `Read by ${book.audiobook_narrators?.join(', ')}` : undefined,
      ]"
      :badges="[
        book.page_count ? `${book.page_count} pages` : undefined,
        book.isbn10 ? `ISBN-10: ${book.isbn10}` : undefined,
        book.isbn13 ? `ISBN-13: ${book.isbn13}` : undefined,
        book.language ? `${book.language.name}` : undefined,
        book.format === 'audio' && book.audiobook_tracks_count ? `${book.audiobook_tracks_count} track${book.audiobook_tracks_count > 1 ? 's' : ''}` : undefined,
        book.format === 'audio' && book.audiobook_chapters_number ? `${book.audiobook_chapters_number} chapter${book.audiobook_chapters_number > 1 ? 's' : ''}` : undefined,
        book.format === 'audio' ? `Duration: ${book.audiobook_duration}` : undefined,
      ]"
      :breadcrumbs="breadcrumbs"
      :square="book.library?.type === 'audiobook'"
    >
      <template #eyebrow>
        <ShowAuthors :authors="book.authors" />
      </template>
      <template #buttons>
        <DownloadButtons
          :title="book.title"
          :model="book"
          type="book"
          :size="size"
          :url="book.download_url"
        />
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
