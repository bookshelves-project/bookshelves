<script lang="ts" setup>
defineProps<{
  query: App.Paginate<App.Models.Book>
  breadcrumbs?: any[]
  title?: string
  square?: boolean
}>()
</script>

<template>
  <App
    :title="title"
    icon="ereader"
  >
    <Listing
      :query="query"
      :sortable="[
        { label: 'Title', value: 'title' },
        { label: 'Release date', value: 'release_date' },
        { label: 'Added at', value: 'added_at' },
        { label: 'Popularity', value: 'popularity' },
        { label: 'Runtime', value: 'runtime' },
      ]"
    >
      <template
        v-if="breadcrumbs"
        #breadcrumbs
      >
        <Breadcrumbs :breadcrumbs="breadcrumbs" />
      </template>
      <CardBook
        v-for="book in query.data"
        :key="book.id"
        :book="book"
        :square="square"
      />
    </Listing>
  </App>
</template>
