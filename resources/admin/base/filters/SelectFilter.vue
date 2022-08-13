<script lang="ts" setup>
import type { Option } from '@admin/composables/choices'
import { getOptionsFromChoices } from '@admin/composables/choices'
import { computed } from 'vue'

const props = defineProps({
  modelValue: [String, Number, Array],
  choices: [Array, Object, String],
  optionText: {
    type: String,
    default: 'text',
  },
  optionValue: {
    type: String,
    default: 'value',
  },
  multiple: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const getChoices = computed((): Option[] => {
  return getOptionsFromChoices(
    props.choices,
    props.optionText,
    props.optionValue,
  )
})

const onFilter = (e: Event) => {
  emit('update:modelValue', (e.target as HTMLInputElement).value)
}

const isSelected = (option: Option) => {
  return props.multiple
    ? ((props.modelValue as string[]) || []).includes(option.value)
    : props.modelValue === option.value
}
</script>

<template>
  <select
    class="py-0"
    @input="onFilter"
  >
    <option value="" />
    <option
      v-for="option in getChoices"
      :key="option.value"
      :value="option.value"
      :selected="isSelected(option)"
    >
      {{ option.text }}
    </option>
  </select>
</template>
