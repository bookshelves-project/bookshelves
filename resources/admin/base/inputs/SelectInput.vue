<script lang="ts" setup>
import { choicesProps, choicesSetup } from '@admin/composables/choices'

const props = defineProps({
  ...choicesProps,
  modelValue: [String, Number, Array],
  multiple: Boolean,
  required: Boolean,
  readonly: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const { getLabel, formValue, getError, id, getName, getChoices, hasError } =
  choicesSetup(props, emit)
</script>

<template>
  <base-input>
    <input-label
      :for="id"
      class="mb-1"
      :required="required"
      :readonly="readonly"
    >
      {{ getLabel }}
    </input-label
    >
    <select
      v-bind="$attrs"
      :id="id"
      v-model="formValue"
      :name="getName"
      class="block w-full scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 dark:scrollbar-track-gray-800 dark:scrollbar-thumb-gray-700 dark:bg-gray-700 dark:border-gray-700"
      :class="{ 'form-invalid': hasError }"
      :multiple="multiple"
      :required="required"
      :readonly="readonly"
    >
      <option
        v-for="option in getChoices"
        :key="option.value"
        :value="option.value"
      >
        {{ option.text }}
      </option>
    </select>
    <input-error
      :message="getError"
      class="mt-2" />
    <input-hint
      :message="hint"
      class="mt-2" />
  </base-input>
</template>
