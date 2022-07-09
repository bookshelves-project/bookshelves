<template>
  <div class="flex justify-between">
    <label class="block text-base font-medium text-gray-700 dark:text-white">
      <span v-if="value">{{ value }}</span>
      <span v-else><slot></slot></span>
      <span
        v-if="required"
        class="text-red-600 dark:text-red-400">*</span>
    </label>
    <span
      v-if="'readonly' in $attrs"
      class="text-gray-500 dark:text-gray-400 text-sm"
    >Readonly</span
    >
  </div>
</template>

<script lang="ts" setup>
defineProps<{
  value?: string
  required?: boolean
  readonly?: boolean
}>()
</script>
