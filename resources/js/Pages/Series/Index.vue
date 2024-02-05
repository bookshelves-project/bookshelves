<script lang="ts" setup>
defineProps<{
  query: App.Paginate<App.Models.Serie>
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
      <CardSerie
        v-for="serie in query.data"
        :key="serie.id"
        :serie="serie"
        :square="square"
      />
    </Listing>
  </App>
</template>
