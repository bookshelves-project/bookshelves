<template>
  <base-input>
    <select-input
      v-model="formValue"
      v-bind="props"
      :choices="choices"
      :required="required"
      :readonly="readonly"
    />
  </base-input>
</template>

<script lang="ts" setup>
import { inputProps, inputSetup } from '@admin/composables/input'
import { referenceSetup } from '@admin/composables/reference'

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
  i18n: Boolean,
  required: Boolean,
  readonly: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const { formValue } = inputSetup(props, emit)

const { choices } = referenceSetup(props, emit)
</script>
