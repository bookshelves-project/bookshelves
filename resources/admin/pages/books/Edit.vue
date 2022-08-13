<script lang="ts" setup>
import type { Book } from '@admin/types'
import type { PropType } from 'vue'
import route from 'ziggy-js'

const props = defineProps({
  book: {
    type: Object as PropType<Book>,
    required: true,
  },
})

const method = 'put'
const url = route('admin.books.update', { id: props.book.id })
</script>

<template>
  <edit-context
    v-slot="{ title }"
    resource="books"
    :item="book"
  >
    <app-layout :title="book.title">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <book-form
        :method="method"
        :url="url"
      />
    </app-layout>
  </edit-context>
</template>
