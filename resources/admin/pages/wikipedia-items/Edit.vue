<template>
  <edit-context
    v-slot="{ title }"
    resource="wikipedia-items"
    :item="wikipediaItem"
  >
    <app-layout :title="wikipediaItem.search_query">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <wikipedia-item-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { WikipediaItem } from '@admin/types'
  import route from 'ziggy-js'

  const props = defineProps({
    wikipediaItem: {
      type: Object as PropType<WikipediaItem>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.wikipedia-items.update', {
    id: props.wikipediaItem.id,
  })
</script>
