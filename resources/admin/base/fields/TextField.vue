<template>
  <a
    v-if="link"
    :href="getText"
    target="_blank"
    rel="noopener noreferrer"
    class="underline relative z-10 hover:bg-gray-200 rounded-md px-2 py-1"
    >{{ getText }}</a
  >
  <span v-else>{{ getText }}</span>
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
    link: Boolean,
  })

  const getText = computed(() => {
    return props.truncate
      ? truncate(props.value, {
          length: props.truncate,
        })
      : props.value
  })
</script>
