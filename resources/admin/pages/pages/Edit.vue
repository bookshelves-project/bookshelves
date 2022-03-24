<template>
  <edit-context v-slot="{ title }" resource="pages" :item="page">
    <app-layout :title="page.title">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <page-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { Page } from '@admin/types'
  import route from 'ziggy-js'

  const props = defineProps({
    page: {
      type: Object as PropType<Page>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.pages.update', { id: props.page.id })
</script>
