<script setup lang="ts">
defineProps<{ full?: boolean }>()
</script>

<template>
  <div
    :class="{ 'md:col-span-3': !full }"
    class="col-span-6 dark:bg-gray-800 border-none p-0"
  >
    <slot />
  </div>
</template>
