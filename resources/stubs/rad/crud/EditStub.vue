<template>
  <edit-context v-slot="{ title }" resource="stubs" :item="stubConcat">
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

      <stubKebab-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { Stub } from '@admin/types'
  import route from 'ziggy-js'

  const props = defineProps({
    stubConcat: {
      type: Object as PropType<Stub>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.stubs.update', { id: props.stubConcat.id })
</script>
