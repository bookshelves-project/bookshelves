<script lang="ts" setup>
defineProps<{
  library: App.Models.Library
  query: App.Paginate<App.Models.Book>
  breadcrumbs?: any[]
  title?: string
  square?: boolean
  series?: boolean
}>()
</script>

<template>
  <App
    :title="title"
    icon="ereader"
  >
    <ListingTabs
      :links="[
        { label: 'Books', href: $route('libraries.show', { library: library.slug }) },
        { label: 'Series', href: $route('series.index', { library: library.slug }) },
      ]"
    />
    <Listing
      :query="query"
      :sortable="series
        ? [
          { label: 'Title', value: 'title' },
          { label: 'Added at', value: 'created_at' },
        ]
        : [
          { label: 'Series\'s Title', value: 'slug' },
          { label: 'Title', value: 'title' },
          { label: 'Release date', value: 'released_on' },
          { label: 'Added at', value: 'added_at' },
        ]"
      :filterable="[
        { label: 'English', value: 'en' },
        { label: 'French', value: 'fr' },
      ]"
    >
      <template
        v-if="breadcrumbs"
        #breadcrumbs
      >
        <Breadcrumbs :breadcrumbs="breadcrumbs" />
      </template>
      <template v-if="series">
        <CardSerie
          v-for="serie in query.data"
          :key="serie.id"
          :serie="serie"
          :square="square"
        />
      </template>
      <template v-else>
        <CardBook
          v-for="book in query.data"
          :key="book.id"
          :book="book"
          :square="square"
        />
      </template>
    </Listing>
  </App>
</template>
