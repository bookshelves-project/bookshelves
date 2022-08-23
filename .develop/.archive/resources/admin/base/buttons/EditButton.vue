<script lang="ts" setup>
import type { Model } from '@admin/types'
import { inject } from 'vue'

defineProps({
  only: Array,
  hideLabel: Boolean,
  parameter: {
    type: String,
    default: 'id',
  },
})

const resource = inject<string>('resource')
const item = inject<Model>('item')
</script>

<template>
  <base-button
    v-if="item"
    icon="pencil"
    variant="invisible"
    :href="route(`admin.${resource}.edit`, { id: item[parameter] })"
    :hide-label="hideLabel"
    :only="only"
  >
    {{ $t('Edit') }}
  </base-button>
</template>
