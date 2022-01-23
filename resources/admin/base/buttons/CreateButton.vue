<template>
  <base-button
    variant="success"
    icon="plus"
    :href="route(`admin.${resource}.create`)"
    :hide-label="hideLabel"
    :only="only"
  >
    {{
      $t('admin.titles.create', {
        args: { resource: $tc(`crud.${resource}.name`, 0) },
      })
    }}
  </base-button>
</template>

<script lang="ts" setup>
  import { inject } from 'vue'

  defineProps({
    only: Array,
    hideLabel: Boolean,
  })

  const resource = inject<string>('resource')
</script>
