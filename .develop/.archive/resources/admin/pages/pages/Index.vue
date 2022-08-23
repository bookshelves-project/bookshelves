<script lang="ts" setup>
import type { Page, PaginatedData } from '@admin/types'
import type { Column } from '@admin/types/data-table'
import type { PropType } from 'vue'

defineProps({
  pages: {
    type: Object as PropType<PaginatedData<Page>>,
    required: true,
  },
  sort: String,
  filter: Object,
})

const columns: (string | Column)[] = [
  'row-action',
  {
    field: 'id',
    width: 40,
    centered: true,
    numeric: true,
    sortable: true,
    main: true,
  },
  {
    field: 'featured_image',
    type: 'image',
    props: {
      preview: 'url',
      original: 'url',
      canPreview: true,
    },
  },
  {
    field: 'title',
    sortable: true,
    searchable: true,
    main: true,
  },
  {
    field: 'summary',
    searchable: true,
  },
  {
    field: 'published_at',
    type: 'date',
    props: { format: 'dd/MM/yyyy' },
    sortable: true,
    searchable: true,
  },
]
</script>

<template>
  <list-context
    v-slot="{ title }"
    resource="pages"
  >
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="pages"
        :columns="columns"
        :sort="sort"
        :filter="filter"
        row-click="edit"
      >
        <template #actions>
          <export-button />
        </template>
        <template #bulk-actions="{ selected }">
          <delete-bulk-button :selected="selected" />
        </template>
        <template #field:row-action>
          <div class="flex gap-2 mx-auto">
            <show-button hide-label />
            <edit-button hide-label />
            <delete-button hide-label />
          </div>
        </template>
      </data-table>
    </app-layout>
  </list-context>
</template>
