<script lang="ts" setup>
defineProps<{
  title: string
  query: App.Paginate<App.Models.Tag>
}>()
</script>

<template>
  <App
    :title="title"
    icon="tag"
  >
    <Listing
      :query="query"
      :sortable="[
        { label: 'Name', value: 'name' },
      ]"
    >
      <template #breadcrumbs>
        <Breadcrumbs
          :breadcrumbs="[
            { label: 'Tags', route: { name: 'tags.index' } },
          ]"
        />
      </template>
      <CardTag
        v-for="(tag, id) in query.data"
        :key="tag.id"
        :tag="tag"
        :current="id"
      />
    </Listing>
  </App>
</template>
