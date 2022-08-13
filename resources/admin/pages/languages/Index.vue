<script lang="ts" setup>
import type { Language, PaginatedData } from '@admin/types'
import type { Column } from '@admin/types/data-table'
import { usePage } from '@inertiajs/inertia-vue3'
import type { PropType } from 'vue'

defineProps({
  languages: {
    type: Object as PropType<PaginatedData<Language>>,
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
    type: 'i18n',
  },
  {
    field: 'books_count',
    centered: true,
    sortable: true,
  },
  {
    field: 'series_count',
    centered: true,
    sortable: true,
  },
]
</script>

<template>
  <list-context
    v-slot="{ title }"
    resource="languages"
  >
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="languages"
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
