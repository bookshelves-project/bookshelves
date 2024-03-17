<script lang="ts" setup>
defineProps<{
  author: App.Models.Author
  breadcrumbs: any[]
}>()
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
        <div class="space-y-10">
          <section v-if="author.series && author.series.length">
            <div class="text-2xl font-semibold">
              Series ({{ author.series.length }})
            </div>
            <div class="books-list mt-6">
              <CardSerie
                v-for="serie in author.series"
                :key="serie.id"
                :serie="serie"
              />
            </div>
          </section>
          <section v-if="author.books && author.books.length">
            <div class="text-2xl font-semibold">
              Books ({{ author.books.length }})
            </div>
            <div class="books-list mt-6">
              <CardBook
                v-for="book in author.books"
                :key="book.id"
                :book="book"
              />
            </div>
          </section>
        </div>
      </template>
    </ShowContainer>
  </App>
</template>
