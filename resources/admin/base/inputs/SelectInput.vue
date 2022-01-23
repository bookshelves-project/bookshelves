<template>
  <input-label :for="id" class="mb-1">{{ getLabel }}</input-label>
  <select
    v-bind="$attrs"
    :id="id"
    v-model="formValue"
    :name="getName"
    class="block w-full"
    :class="{ 'form-invalid': hasError }"
    :multiple="multiple"
  >
    <option
      v-for="option in getChoices"
      :key="option.value"
      :value="option.value"
    >
      {{ option.text }}
    </option>
  </select>
  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
</template>

<script lang="ts" setup>
  import { choicesProps, choicesSetup } from '@admin/mixins/choices'

  const props = defineProps({
    ...choicesProps,
    modelValue: [String, Number, Array],
    multiple: Boolean,
  })

  const emit = defineEmits(['update:modelValue'])

  const { getLabel, formValue, getError, id, getName, getChoices, hasError } =
    choicesSetup(props, emit)
</script>
