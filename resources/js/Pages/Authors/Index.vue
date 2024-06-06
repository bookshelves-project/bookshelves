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
    <CardAuthor
      v-for="author in query.data"
      :key="author.id"
      :author="author"
    />
    <!-- <Listing
      :query="query"
      :sortable="[
        { label: 'Name', value: 'name' },
        { label: 'Lastname', value: 'lastname' },
        { label: 'Firstname', value: 'firstname' },
        { label: 'Updated at', value: 'updated_at' },
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
    </Listing> -->
  </App>
</template>
