<template>
  <base-button
    variant="success"
    icon="plus"
    :href="route(`admin.${resource}.create`)"
    :hide-label="hideLabel"
    :only="only"
  >
    <span v-if="label">{{ label }}</span>
    <span v-else>{{
      $t('admin.titles.create', {
        args: { resource: $tc(`crud.${resource}.name`, 0) },
      })
    }}</span>
  </base-button>
</template>

<script lang="ts" setup>
import { inject } from 'vue'

defineProps<{
  only?: any[]
  hideLabel?: boolean
  label?: string
}>()

const resource = inject<string>('resource')
</script>
