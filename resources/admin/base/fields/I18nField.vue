<template>
  <span>{{ getLocaleText }}</span>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import truncate from 'lodash/truncate'
import { usePage } from '@inertiajs/inertia-vue3'

const props = defineProps({
  value: {
    type: Object,
    required: true,
  },
})

const locale = computed(() => usePage().props.value.locale)

const getLocaleText = computed(() => {
  // eslint-disable-next-line no-prototype-builtins
  if (props.value.hasOwnProperty(locale.value)) {
    return props.value[locale.value]
  } else {
    return props.value[Object.keys(props.value)[0]]
  }
})
</script>
