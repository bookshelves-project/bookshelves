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
        { label: 'Library', href: `/libraries/${library.slug}` },
        { label: 'Series', href: `/libraries/${library.slug}/series` },
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
          { label: 'Title', value: 'title' },
          { label: 'Release date', value: 'released_on' },
          { label: 'Added at', value: 'added_at' },
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
