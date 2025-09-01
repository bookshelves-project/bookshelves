<script lang="ts" setup>
defineProps<{
  name: string
  value?: string | number | null
}>();

</script>
<template>
  <div class="flex justify-between gap-x-4 py-3">
    <dt class="text-gray-500 dark:text-gray-400">{{ name }}</dt>
    <dd class="text-gray-700 dark:text-gray-300">{{ value }}</dd>
  </div>
</template>
