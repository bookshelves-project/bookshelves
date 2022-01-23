<template>
  <select-filter v-model="value" :choices="choices" />
</template>

<script lang="ts" setup>
  import { __ } from 'matice'
  import { computed } from 'vue'

  const props = defineProps({
    modelValue: String,
  })

  const emit = defineEmits(['update:modelValue'])

  const choices = {
    1: __('admin.yes'),
    0: __('admin.no'),
  }

  const value = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val),
  })
</script>
