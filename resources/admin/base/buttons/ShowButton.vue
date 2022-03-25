<template>
  <base-button
    v-if="item"
    icon="eye"
    :href="route(`admin.${resource}.show`, { id: item[parameter] })"
    variant="invisible"
    :hide-label="hideLabel"
    :only="only"
  >
    {{ $t('Show') }}
  </base-button>
</template>

<script lang="ts" setup>
import { Model } from '@admin/types'
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
