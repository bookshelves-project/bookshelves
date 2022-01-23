<template>
  <list-context v-slot="{ title }" resource="posts">
    <app-layout>
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <create-button />
          </template>
        </page-header>
      </template>

      <data-table
        :source="posts"
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
          <div class="flex gap-2 ml-auto">
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
  import { PaginatedData, Post } from '@admin/types'
  import { Column } from '@admin/types/data-table'
  import { PropType } from 'vue'

  defineProps({
    posts: {
      type: Object as PropType<PaginatedData<Post>>,
      required: true,
    },
    sort: String,
    filter: Object,
  })

  const columns: (string | Column)[] = [
    {
      field: 'id',
      width: 40,
      numeric: true,
      sortable: true,
    },
    {
      field: 'featured_image',
      type: 'image',
      props: {
        canPreview: true,
      },
    },
    {
      field: 'title',
      sortable: true,
      searchable: true,
    },
    {
      field: 'status',
      type: 'select',
      props: {
        choices: 'post_statuses',
      },
      searchable: true,
    },
    {
      field: 'category',
      type: 'reference',
      props: {
        text: 'name',
        resource: 'post-categories',
      },
      searchable: true,
    },
    {
      field: 'summary',
      type: 'text',
      props: { truncate: 60 },
      searchable: true,
    },
    {
      field: 'pin',
      type: 'switch',
      searchable: true,
    },
    {
      field: 'promote',
      type: 'switch',
      searchable: true,
    },
    {
      field: 'user',
      type: 'reference',
      props: { text: 'name', resource: 'users', link: 'show' },
      searchable: true,
      filterType: 'text',
    },
    {
      field: 'published_at',
      type: 'date',
      props: { format: 'dd/MM/yyyy HH:mm' },
      sortable: true,
      centered: true,
      searchable: true,
    },
    {
      field: 'created_at',
      type: 'date',
      sortable: true,
      centered: true,
    },
    {
      field: 'updated_at',
      type: 'date',
      sortable: true,
      centered: true,
    },
    'row-action',
  ]
</script>
