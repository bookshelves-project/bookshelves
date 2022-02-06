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
      field: 'title',
      type: 'text',
      props: {
        truncate: 50,
      },
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
      field: 'volume',
      width: 10,
      centered: true,
      sortable: true,
    },
    {
      field: 'type',
      type: 'select',
      props: {
        choices: 'book_types',
      },
      searchable: true,
    },
    // {
    //   field: 'category',
    //   type: 'reference',
    //   props: {
    //     text: 'name',
    //     resource: 'post-categories',
    //   },
    //   searchable: true,
    // },
    // {
    //   field: 'summary',
    //   type: 'text',
    //   props: { truncate: 60 },
    //   searchable: true,
    // },
    // {
    //   field: 'pin',
    //   type: 'switch',
    //   searchable: true,
    // },
    {
      field: 'language',
      type: 'reference',
      props: {
        text: 'name',
        resource: 'languages.fetch',
      },
      sortable: true,
      searchable: true,
    },
    {
      field: 'disabled',
      type: 'switch',
      searchable: true,
    },
    {
      field: 'tags_count',
      centered: true,
      sortable: true,
    },
    {
      field: 'publisher',
      type: 'reference',
      props: {
        text: 'name',
        resource: 'publishers',
        // link: 'show',
      },
      sortable: true,
      filterType: 'text',
      searchable: true,
    },

    // {
    //   field: 'user',
    //   type: 'reference',
    //   props: { text: 'name', resource: 'users', link: 'show' },
    //   searchable: true,
    //   filterType: 'text',
    // },
    {
      field: 'released_on',
      type: 'date',
      props: { format: 'dd/MM/yyyy' },
      sortable: true,
      centered: true,
      searchable: true,
    },
    // {
    //   field: 'created_at',
    //   type: 'date',
    //   sortable: true,
    //   centered: true,
    // },
    {
      field: 'updated_at',
      type: 'date',
      sortable: true,
      centered: true,
    },
  ]
</script>
