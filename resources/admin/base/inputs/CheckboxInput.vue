<template>
  <label class="flex items-center">
    <input
      v-model="formValue"
      v-bind="$attrs"
      :name="getName"
      type="checkbox"
    />
    <span class="ml-2 text-sm text-gray-600">{{ getLabel }}</span>
  </label>
  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
</template>

<script lang="ts" setup>
  import { inputProps, inputSetup } from '@admin/mixins/input'

  const props = defineProps({
    ...inputProps,
    modelValue: {
      type: Boolean,
      default: false,
    },
  })

  const emit = defineEmits(['update:modelValue'])

  const { getLabel, getName, formValue, getError } = inputSetup(props, emit)
</script>
