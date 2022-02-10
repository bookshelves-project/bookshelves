<template>
  <list-context v-slot="{ title }" resource="wikipedia-items">
    <app-layout :title="title">
      <template #header-actions>
        <create-button />
      </template>

      <data-table
        :source="wikipediaItems"
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
  import { PaginatedData, WikipediaItem } from '@admin/types'
  import { Column } from '@admin/types/data-table'
  import { PropType } from 'vue'

  defineProps({
    wikipediaItems: {
      type: Object as PropType<PaginatedData<WikipediaItem>>,
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
      field: 'page_id',
      sortable: true,
      searchable: true,
    },
    {
      field: 'search_query',
      sortable: true,
      searchable: true,
    },
    {
      field: 'serie',
      type: 'reference',
      props: {
        text: 'title',
        resource: 'series',
        link: 'show',
      },
      searchable: true,
      filterType: 'text',
      sortable: true,
    },
    {
      field: 'author',
      type: 'reference',
      props: {
        text: 'name',
        resource: 'authors',
        link: 'show',
      },
      searchable: true,
      filterType: 'text',
      sortable: true,
    },
    {
      field: 'query_url',
      type: 'text',
      props: {
        link: true,
      },
    },
  ]
</script>
