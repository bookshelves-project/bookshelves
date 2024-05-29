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
    >
      <template #swipers>
        <div
          v-if="books.length || series.length"
          class="space-y-24"
        >
          <section>
            <h2 class="text-3xl font-semibold">
              Series of {{ author.name }}
            </h2>
            <div class="mt-6 border-t border-gray-500">
              <dl class="divide-y divide-dashed divide-gray-500">
                <div
                  v-for="library in series"
                  :key="library.name"
                  class="px-4 py-6 sm:px-0"
                >
                  <dd class="mt-1 text-sm leading-6 sm:mt-0">
                    <div class="text-xl font-semibold">
                      {{ library.name }} ({{ library.models.length }})
                    </div>
                    <div class="books-list mt-6">
                      <CardSerie
                        v-for="serie in library.models"
                        :key="serie.id"
                        :serie="serie"
                        :square="serie.library?.type === 'audiobook'"
                      />
                    </div>
                  </dd>
                </div>
              </dl>
            </div>
          </section>
          <section>
            <h2 class="text-3xl font-semibold">
              Books of {{ author.name }}
            </h2>
            <div class="mt-6 border-t border-gray-500">
              <dl class="divide-y divide-dashed divide-gray-500">
                <div
                  v-for="library in books"
                  :key="library.name"
                  class="px-4 py-6 sm:px-0"
                >
                  <dd class="mt-1 text-sm leading-6 sm:mt-0">
                    <div class="text-xl font-semibold">
                      {{ library.name }} ({{ library.models.length }})
                    </div>
                    <div class="books-list mt-6">
                      <CardBook
                        v-for="book in library.models"
                        :key="book.id"
                        :book="book"
                        :square="book.library?.type === 'audiobook'"
                      />
                    </div>
                  </dd>
                </div>
              </dl>
            </div>
          </section>
        </div>
      </template>
    </ShowContainer>
  </App>
</template>
