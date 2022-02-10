<template>
  <list-context v-slot="{ title }" resource="series">
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="series"
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
  import { PaginatedData, Serie } from '@admin/types'
  import { Column } from '@admin/types/data-table'
  import { PropType } from 'vue'

  defineProps({
    series: {
      type: Object as PropType<PaginatedData<Serie>>,
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
      field: 'title',
      sortable: true,
      searchable: true,
    },
    {
      field: 'authors',
      type: 'reference',
      props: {
        text: 'name',
        resource: 'authors',
        link: 'show',
      },
      sortable: true,
      filterType: 'text',
      searchable: true,
    },
    {
      field: 'books_count',
      centered: true,
      sortable: true,
    },
    {
      field: 'tags_count',
      centered: true,
      sortable: true,
    },
    {
      field: 'language',
      type: 'reference',
      props: {
        text: 'name',
        resource: 'languages',
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
