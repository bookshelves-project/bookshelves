<template>
  <span
    v-if="!link && value"
    class="inline-block px-2 py-1 text-white text-sm rounded bg-gray-400"
  >
    <span v-for="(item, index) in value" :key="index">
      {{ item instanceof Object && text ? item[text] : '' }}
    </span>
  </span>
</template>

<script lang="ts" setup>
  defineProps({
    value: {
      type: Array,
      required: true,
    },
    text: String,
    resource: String,
    link: String,
  })
</script>
