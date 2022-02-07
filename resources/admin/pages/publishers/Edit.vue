<template>
  <edit-context v-slot="{ title }" resource="publishers" :item="publisher">
    <app-layout>
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <publisher-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { Publisher } from '@admin/types'
  import { PropType } from 'vue'
  import route from 'ziggy-js'

  const props = defineProps({
    publisher: {
      type: Object as PropType<Publisher>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.publishers.update', { id: props.publisher.id })
</script>
