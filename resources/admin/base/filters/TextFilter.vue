<template>
  <input :value="modelValue" type="text" @input="onFilter" />
</template>

<script lang="ts" setup>
  import {} from 'vue'

  defineProps({
    modelValue: String,
  })

  const emit = defineEmits(['update:modelValue'])

  const onFilter = (e: Event) => {
    emit('update:modelValue', (e.target as HTMLInputElement).value)
  }
</script>
