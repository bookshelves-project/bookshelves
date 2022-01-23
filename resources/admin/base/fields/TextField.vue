<template>
  <span>{{ getText }}</span>
</template>

<script lang="ts" setup>
  import { computed } from 'vue'
  import truncate from 'lodash/truncate'

  const props = defineProps({
    value: {
      type: String,
      required: true,
    },
    truncate: Number,
  })

  const getText = computed(() => {
    return props.truncate
      ? truncate(props.value, {
          length: props.truncate,
        })
      : props.value
  })
</script>
