<template>
  <list-context v-slot="{ title }" resource="google-books">
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="googleBooks"
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

<script lang="ts" setup>
  import { PaginatedData, GoogleBook } from '@admin/types'
  import { Column } from '@admin/types/data-table'
  import { PropType } from 'vue'

  defineProps({
    googleBooks: {
      type: Object as PropType<PaginatedData<GoogleBook>>,
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
      field: 'original_isbn',
      sortable: true,
      searchable: true,
    },
    {
      field: 'book',
      type: 'reference',
      props: {
        text: 'title',
        resource: 'books',
        link: 'show',
      },
      searchable: true,
      filterType: 'text',
      sortable: true,
    },
    {
      field: 'url',
      type: 'text',
      props: {
        link: true,
      },
    },
  ]
</script>
