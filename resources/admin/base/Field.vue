<template>
  <div>
    <label class="font-medium text-sm text-gray-700">{{ $ta(source) }}</label>
    <div>
      <template v-if="value !== null && value !== undefined">
        <component
          :is="`${type}-field`"
          v-if="type"
          :value="value"
          v-bind="$attrs"
        ></component>
        <span v-else>{{ value }}</span>
      </template>
      <span v-else>-</span>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { inject } from 'vue'
  import get from 'lodash/get'

  const props = defineProps({
    source: {
      type: String,
      required: true,
    },
    type: String,
  })

  const item = inject<any>('item', null)
  const value = item ? get(item, props.source) : null
</script>
