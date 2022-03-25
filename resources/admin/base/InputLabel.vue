<template>
  <label class="block text-base font-medium text-gray-700 dark:text-white">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot></slot></span>
  </label>
</template>

<script lang="ts" setup>
defineProps({
  value: String,
})
</script>
