<template>
  <base-button
    tag="a"
    variant="success"
    icon="download"
    :href="exportUrl"
    :hide-label="hideLabel"
  >
    {{ $t('admin.data-table.export') }}
  </base-button>
</template>

<script lang="ts" setup>
  import { computed, inject } from 'vue'
  import route from 'ziggy-js'
  import qs from 'qs'

  defineProps({
    hideLabel: Boolean,
  })

  const resource = inject<string>('resource')
  const filter = inject<{ [key: string]: string }>('filter')

  const exportUrl = computed((): string => {
    return `${route(`admin.${resource}`)}?${qs.stringify({
      filter,
      export: true,
    })}`
  })
</script>
