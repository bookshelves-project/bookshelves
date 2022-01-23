<template>
  <span
    :title="value ? $t('admin.yes') : $t('admin.no')"
    class="inline-flex p-1 rounded text-white"
    :class="value ? 'bg-green-500' : 'bg-red-500'"
  >
    <component :is="value ? 'check-icon' : 'x-icon'" class="h-5 w-5" />
  </span>
</template>

<script lang="ts" setup>
  defineProps({
    value: {
      type: Boolean,
      required: true,
    },
  })
</script>
