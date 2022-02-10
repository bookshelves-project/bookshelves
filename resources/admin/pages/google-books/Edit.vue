<template>
  <edit-context v-slot="{ title }" resource="google-books" :item="googleBook">
    <app-layout :title="googleBook.original_isbn">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <google-book-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { GoogleBook } from '@admin/types'
  import route from 'ziggy-js'

  const props = defineProps({
    googleBook: {
      type: Object as PropType<GoogleBook>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.google-books.update', { id: props.googleBook.id })
</script>
