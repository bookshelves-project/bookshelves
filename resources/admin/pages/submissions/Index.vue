<template>
  <list-context
    v-slot="{ title }"
    resource="submissions">
    <app-layout :title="title">
      <data-table
        :source="submissions"
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
            <show-external-button
              hide-label
              path="path"
              :query="{ preview: true }"
            />
            <delete-button hide-label />
          </div>
        </template>
      </data-table>
    </app-layout>
  </list-context>
</template>

<script lang="ts" setup>
import { PaginatedData, Submission } from '@admin/types'
import { Column } from '@admin/types/data-table'
import { PropType } from 'vue'

defineProps({
  submissions: {
    type: Object as PropType<PaginatedData<Submission>>,
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
    field: 'email',
    sortable: true,
    searchable: true,
  },
  {
    field: 'message',
  },
  {
    field: 'created_at',
    type: 'date',
    sortable: true,
    centered: true,
  },
]
</script>
