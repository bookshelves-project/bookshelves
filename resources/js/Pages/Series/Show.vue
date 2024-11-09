<script lang="ts" setup>
import { useDownload } from '@/Composables/useDownload'
import { useUtils } from '@/Composables/useUtils'

const props = defineProps<{
  serie: App.Models.Serie
  square?: boolean
}>()

const size = ref<string>()
const extension = ref<string>()
const { bytesToHuman, getSize } = useUtils()

const titlePage = computed(() => {
  return `${props.serie.title} (${props.serie.library?.type_label}) · ${props.serie.books_count} books`
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
        serie.language ? `${serie.language.name}` : undefined,
        serie.library?.type_label,
      ]"
      :breadcrumbs="[
        { label: serie.library?.name, route: { name: 'libraries.show', params: { library: serie.library?.slug } } },
        { label: 'Series', route: { name: 'series.index', params: { library: serie.library?.slug } } },
        { label: serie.title, route: { name: 'series.show', params: { library: serie.library?.slug, serie: serie.slug } } },
      ]"
      :square="serie.library?.type === 'audiobook'"
    >
      <template #eyebrow>
        <ShowAuthors :authors="serie.authors" />
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
