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
    <!-- <ILink :href="`/libraries/${library.slug}`">
      library
    </ILink>
    <ILink :href="`/libraries/${library.slug}/series`">
      series
    </ILink> -->
    <ListingTabs
      :links="[
        { label: 'Library', href: `/libraries/${library.slug}` },
        { label: 'Series', href: `/libraries/${library.slug}/series` },
      ]"
    />
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
