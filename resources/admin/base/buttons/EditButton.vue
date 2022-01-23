<template>
  <base-button
    v-if="item"
    icon="pencil"
    variant="info"
    :href="route(`admin.${resource}.edit`, { id: item.id })"
    :hide-label="hideLabel"
    :only="only"
  >
    {{ $t('Edit') }}
  </base-button>
</template>

<script lang="ts" setup>
  import { Model } from '@admin/types'
  import { inject } from 'vue'

  defineProps({
    only: Array,
    hideLabel: Boolean,
  })

  const resource = inject<string>('resource')
  const item = inject<Model>('item')
</script>
