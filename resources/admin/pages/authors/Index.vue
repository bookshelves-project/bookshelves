<template>
  <list-context v-slot="{ title }" resource="authors">
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="authors"
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

<script lang="ts" setup>
  import { Author, PaginatedData } from '@admin/types'
  import { Column } from '@admin/types/data-table'
  import { PropType } from 'vue'

  defineProps({
    authors: {
      type: Object as PropType<PaginatedData<Author>>,
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
      field: 'cover',
      type: 'image',
      props: {
        preview: 'url',
        original: 'url',
        canPreview: true,
      },
      main: true,
    },
    {
      field: 'firstname',
      sortable: true,
      searchable: true,
      main: true,
    },
    {
      field: 'lastname',
      sortable: true,
      searchable: true,
      main: true,
    },
    {
      field: 'role',
      type: 'select',
      props: {
        choices: 'author_roles',
      },
      searchable: true,
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
    {
      field: 'updated_at',
      type: 'date',
      sortable: true,
      centered: true,
    },
  ]
</script>
