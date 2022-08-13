<script lang="ts" setup>
import type { PaginatedData, Tag } from '@admin/types'
import type { Column } from '@admin/types/data-table'
import type { PropType } from 'vue'

defineProps({
  tags: {
    type: Object as PropType<PaginatedData<Tag>>,
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
    field: 'name',
    sortable: true,
    searchable: true,
    main: true,
  },
  {
    field: 'first_char',
    sortable: true,
  },
  {
    field: 'type',
    type: 'select',
    props: {
      choices: 'tag_types',
    },
    sortable: true,
    searchable: true,
    main: true,
  },
  {
    field: 'books_count',
    sortable: true,
  },
  {
    field: 'series_count',
    sortable: true,
  },
  {
    field: 'created_at',
    type: 'date',
    sortable: true,
    centered: true,
  },
]
</script>

<template>
  <list-context
    v-slot="{ title }"
    resource="tags"
  >
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="tags"
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
            <edit-button hide-label />
            <delete-button hide-label />
          </div>
        </template>
      </data-table>
    </app-layout>
  </list-context>
</template>
