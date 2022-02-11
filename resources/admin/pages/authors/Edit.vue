<template>
  <edit-context v-slot="{ title }" resource="authors" :item="author">
    <app-layout :title="author.name">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <author-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { Author } from '@admin/types'
  import { PropType } from 'vue'
  import route from 'ziggy-js'

  const props = defineProps({
    author: {
      type: Object as PropType<Author>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.authors.update', { id: props.author.id })
</script>
