<template>
  <edit-context v-slot="{ title }" resource="series" :item="serie">
    <app-layout :title="serie.title">
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <serie-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { Serie } from '@admin/types'
  import { PropType } from 'vue'
  import route from 'ziggy-js'

  const props = defineProps({
    serie: {
      type: Object as PropType<Serie>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.series.update', { id: props.serie.id })
</script>
