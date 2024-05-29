<script lang="ts" setup>
import { useFetch } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  author: App.Models.Author
  breadcrumbs: any[]
}>()

const libraries = ref<{
  name: string
  books: App.Models.Book[]
  series: App.Models.Serie[]
}[]>([])

const { http } = useFetch()

async function fetchItems() {
  const url = `/api/authors/${props.author.slug}`
  const res: Response | undefined = await http.get(url)

  if (res) {
    const body = await res.json()
    libraries.value = body.data
  }
  else {
    console.error('SwiperHome: No response')
  }
}
fetchItems()
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
          v-if="libraries.length"
          class="space-y-24"
        >
          <section>
            <h2 class="text-3xl font-semibold">
              Series of {{ author.name }}
            </h2>
            <div class="mt-6 border-t border-gray-500">
              <dl class="divide-y divide-dashed divide-gray-500">
                <div
                  v-for="library in libraries"
                  :key="library.name"
                  class="px-4 py-6 sm:px-0"
                >
                  <dd class="mt-1 text-sm leading-6 sm:mt-0">
                    <div class="text-xl font-semibold">
                      {{ library.name }} ({{ library.series.length }})
                    </div>
                    <div class="books-list mt-6">
                      <CardSerie
                        v-for="serie in library.series"
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
                  v-for="library in libraries"
                  :key="library.name"
                  class="px-4 py-6 sm:px-0"
                >
                  <dd class="mt-1 text-sm leading-6 sm:mt-0">
                    <div class="text-xl font-semibold">
                      {{ library.name }} ({{ library.books.length }})
                    </div>
                    <div class="books-list mt-6">
                      <CardBook
                        v-for="book in library.books"
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
