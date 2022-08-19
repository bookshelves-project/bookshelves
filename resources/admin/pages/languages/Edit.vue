<script lang="ts" setup>
import type { Language } from '@admin/types'
import type { PropType } from 'vue'
import route from 'ziggy-js'

const props = defineProps({
  language: {
    type: Object as PropType<Language>,
    required: true,
  },
})

const method = 'put'
const url = route('admin.languages.update', { id: props.language.id })
</script>

<template>
  <edit-context
    v-slot="{ title }"
    resource="languages"
    :item="language"
  >
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

      <language-form
        :method="method"
        :url="url"
      />
    </app-layout>
  </edit-context>
</template>
