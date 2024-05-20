<script lang="ts" setup>
defineProps<{
  query: App.Paginate<App.Models.Author>
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
        { label: 'Name', value: 'name' },
        { label: 'Lastname', value: 'lastname' },
        { label: 'Firstname', value: 'firstname' },
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
      <CardAuthor
        v-for="author in query.data"
        :key="author.id"
        :author="author"
      />
    </Listing>
  </App>
</template>
