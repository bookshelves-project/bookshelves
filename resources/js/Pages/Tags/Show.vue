<script lang="ts" setup>
defineProps<{
  tag: App.Models.Tag
  query: App.Paginate<App.Models.Book>
  breadcrumbs?: any[]
  title?: string
  series?: boolean
}>()
</script>

<template>
  <App
    :title="title"
    icon="tag"
  >
    <ListingTabs
      :links="[
        { label: 'Books', href: $route('tags.show', { tag: tag.slug }) },
        { label: 'Series', href: $route('tags.show.series', { tag: tag.slug }) },
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
        />
      </template>
      <template v-else>
        <CardBook
          v-for="book in query.data"
          :key="book.id"
          :book="book"
        />
      </template>
    </Listing>
  </App>
</template>
