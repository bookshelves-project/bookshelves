<script lang="ts" setup>
import { useFetch } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  author: App.Models.Author
  breadcrumbs: any[]
}>()

const books = ref<{
  name: string
  models: App.Models.Book[]
}[]>([])

const series = ref<{
  name: string
  models: App.Models.Serie[]
}[]>([])

const { http } = useFetch()

async function fetchItems(url: string, items: Ref<any>) {
  try {
    const res = await http.get(url)
    const body = await res.json()
    items.value = body.data
  }
  catch (error) {
    console.error(`Failed to fetch ${url}`)
  }
}

fetchItems(`/api/authors/${props.author.slug}/series`, series)

onMounted(() => {
  fetchItems(`/api/authors/${props.author.slug}/books`, books)
})
</script>

<template>
  <App
    :title="author.name"
    :description="author.description"
    :image="author.cover_social"
    icon="quill"
  >
    <ShowContainer
      :model="author"
      :title="author.name"
      :cover="author.cover_standard"
      :cover-color="author.cover_color"
      :overview="author.description"
      :breadcrumbs="[
        { label: 'Authors', route: { name: 'authors.index' } },
        { label: `${author.name}`, route: { name: 'authors.show', params: { author: author.slug } } },
      ]"
    >
      <template #swipers>
        <div
          v-if="books.length || series.length"
          class="space-y-24"
        >
          <AuthorBooks
            :author="author"
            :library="series"
            type="serie"
          />
          <AuthorBooks
            :author="author"
            :library="books"
            type="book"
          />
        </div>
      </template>
    </ShowContainer>
  </App>
</template>
