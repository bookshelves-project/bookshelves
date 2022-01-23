<template>
  <select-filter
    v-model="value"
    :choices="choices"
    :option-text="optionText"
    :option-value="optionValue"
  />
</template>

<script lang="ts" setup>
  import { referenceSetup } from '@admin/mixins/reference'
  import {} from 'vue'

  const props = defineProps({
    modelValue: String,
    resource: {
      type: String,
      required: true,
    },
    optionText: {
      type: String,
      default: 'name',
    },
    optionValue: {
      type: String,
      default: 'id',
    },
  })

  const emit = defineEmits(['update:modelValue'])
  const { value, choices } = referenceSetup(props, emit)
</script>
