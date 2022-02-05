<template>
  <list-context v-slot="{ title }" resource="books">
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="books"
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
            <edit-button hide-label />
            <delete-button hide-label />
          </div>
        </template>
      </data-table>
    </app-layout>
  </list-context>
</template>

<script lang="ts" setup>
  import { Book, PaginatedData } from '@admin/types'
  import { Column } from '@admin/types/data-table'
  import { PropType } from 'vue'

  defineProps({
    books: {
      type: Object as PropType<PaginatedData<Book>>,
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
    },
    {
      field: 'cover',
      type: 'image',
      props: {
        preview: 'url',
        original: 'url',
        canPreview: true,
      },
    },
    {
      field: 'firstname',
      sortable: true,
      searchable: true,
    },
    {
      field: 'lastname',
      sortable: true,
      searchable: true,
    },
    {
      field: 'description',
      type: 'text',
      props: {
        truncate: 50,
      },
      sortable: true,
      searchable: true,
    },
    {
      field: 'updated_at',
      type: 'date',
      sortable: true,
      centered: true,
    },
  ]
</script>
