<template>
  <span>{{ $dateFormat(value, format) }}</span>
</template>

<script lang="ts" setup>
  defineProps({
    value: {
      type: [String, Number],
      required: true,
    },
    format: {
      type: String,
      default: 'dd/MM/yyyy',
    },
  })
</script>
