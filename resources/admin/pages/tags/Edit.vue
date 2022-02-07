<template>
  <edit-context v-slot="{ title }" resource="tags" :item="tag">
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

      <tag-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { Tag } from '@admin/types'
  import { PropType } from 'vue'
  import route from 'ziggy-js'

  const props = defineProps({
    tag: {
      type: Object as PropType<Tag>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.tags.update', { id: props.tag.id })
</script>
