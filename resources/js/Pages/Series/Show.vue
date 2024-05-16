<script lang="ts" setup>
import { useUtils } from '@/Composables/useUtils'

const props = defineProps<{
  serie: App.Models.Serie
  square?: boolean
}>()

const size = ref<string>()
const extension = ref<string>()
const { bytesToHuman, ucfirst, getSize } = useUtils()

const titlePage = computed(() => {
  return `${props.serie.title} (${props.serie.type}) into ${props.serie.language?.name} · ${props.serie.books_count} books`
})

onMounted(async () => {
  const api = await getSize('serie', props.serie.id)
  size.value = bytesToHuman(api.size)
  extension.value = api.extension
})
</script>

<template>
  <App
    :title="titlePage"
    :description="serie.description"
    :image="serie.cover_social"
    icon="catalog"
  >
    <ShowContainer
      :model="serie"
      :type="ucfirst(serie.type)"
      :title="serie.title"
      :cover="serie.cover_standard"
      :cover-color="serie.cover_color"
      :backdrop="serie.cover_social"
      :overview="serie.description"
      :tags="serie.tags"
      :badges="[
        `${serie.books_count} books`,
        serie.language ? `${serie.language.name}` : undefined,
        ucfirst(serie.type),
      ]"
      :download="{
        url: serie.download_link,
        size,
        extension,
      }"
      :breadcrumbs="[
        { label: 'Series', route: { name: 'home' } },
        { label: serie.title, route: { name: 'home' } },
      ]"
    >
      <template #eyebrow>
        <ShowAuthors :authors="serie.authors" />
      </template>
      <template #swipers>
        <section
          v-if="serie.books && serie.books.length"
          class="books-list"
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
