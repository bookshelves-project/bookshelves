<script lang="ts" setup>
import { useUtils } from '@/Composables/useUtils'

const props = defineProps<{
  serie: App.Models.Serie
  square?: boolean
}>()

const size = ref<string>()
const extension = ref<string>()
const { bytesToHuman, getSize } = useUtils()
const langISO = `(${props.serie.language?.slug.toUpperCase()})` || ''

const titlePage = computed(() => {
  return `${props.serie.title} (${props.serie.library?.type_label}) · ${props.serie.books_count} books (${props.serie.language?.name})`
})

onMounted(async () => {
  const api = await getSize('serie', props.serie.id)
  size.value = bytesToHuman(api?.size)
  extension.value = api?.extension
})
</script>

<template>
  <App
    :title="titlePage"
    :description="serie.description"
    :image="serie.cover_social"
    :icon="serie.format_icon as SvgName"
  >
    <ShowContainer
      :model="serie"
      :library="serie.library"
      :title="`${serie.title}'s Series`"
      :cover="serie.cover_standard"
      :cover-color="serie.cover_color"
      :backdrop="serie.cover_social"
      :overview="serie.description"
      :tags="serie.tags"
      :badges="[
        `${serie.books_count} books`,
        serie.library?.type_label,
      ]"
      :breadcrumbs="[
        { label: serie.library?.name, route: { name: 'libraries.show', params: { library: serie.library?.slug } } },
        { label: 'Series', route: { name: 'series.index', params: { library: serie.library?.slug } } },
        { label: `${serie.title} ${langISO}`, route: { name: 'series.show', params: { library: serie.library?.slug, serie: serie.slug } } },
      ]"
      :square="serie.library?.type === 'audiobook'"
      :language="serie.language"
    >
      <template #eyebrow>
        <ShowAuthors
          :authors="serie.authors"
          :language="serie.language"
        />
      </template>
      <template #buttons>
        <DownloadButtons
          :title="serie.title"
          :model="serie"
          type="serie"
          :size="size"
          :url="serie.download_url"
        />
      </template>
      <template #swipers>
        <section
          v-if="serie.books && serie.books.length"
          class="books-grid"
        >
          <CardBook
            v-for="book in serie.books"
            :key="book.id"
            :book="book"
            :square="square"
          />
        </section>
      </template>
    </ShowContainer>
  </App>
</template>
