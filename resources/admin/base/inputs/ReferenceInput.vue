<template>
  <select-input v-model="formValue" v-bind="props" :choices="choices" />
</template>

<script lang="ts" setup>
  import { inputProps, inputSetup } from '@admin/mixins/input'
  import { referenceSetup } from '@admin/mixins/reference'
  import {} from 'vue'

  const props = defineProps({
    ...inputProps,
    modelValue: [String, Number, Array],
    multiple: Boolean,
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
    allowEmpty: Boolean,
    emptyText: String,
  })

  const emit = defineEmits(['update:modelValue'])

  const { formValue } = inputSetup(props, emit)

  const { choices } = referenceSetup(props, emit)
</script>
