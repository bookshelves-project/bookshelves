<template>
  <base-button
    variant="info"
    icon="view-list"
    :href="route(`admin.${resource}`)"
    :hide-label="hideLabel"
  >
    {{
      $t('admin.titles.index', {
        args: { resource: $tc(`crud.${resource}.name`, 10) },
      })
    }}
  </base-button>
</template>

<script lang="ts" setup>
  import { inject } from 'vue'

  defineProps({
    hideLabel: Boolean,
  })

  const resource = inject<string>('resource')
</script>
