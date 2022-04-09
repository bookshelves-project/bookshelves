<template>
  <base-input>
    <input-label
      :for="id"
      class="mb-1"
      :value="getLabel"
      :required="'required' in $attrs"
      :readonly="'readonly' in $attrs"
    />
    <textarea
      v-if="multiline"
      v-bind="$attrs"
      :id="id"
      ref="input"
      v-model="formValue"
      :name="getName"
      rows="4"
      class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 rounded-md scrollbar-thin dark:text-white"
      :class="{ 'form-invalid': hasError }"
    />
    <input
      v-else
      v-bind="$attrs"
      :id="id"
      ref="input"
      v-model="formValue"
      :name="getName"
      class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 rounded-md dark:text-white"
      :class="{ 'form-invalid': hasError }"
    />
    <input-error :message="getError" class="mt-2" />
    <input-hint :message="hint" class="mt-2" />
  </base-input>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue'
import { inputProps, inputSetup } from '@admin/composables/input'

const props = defineProps({
  ...inputProps,
  modelValue: String,
  multiline: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const input: Ref<HTMLInputElement | null> = ref(null)
const { getLabel, formValue, getError, hasError, id, getName } = inputSetup(
  props,
  emit
)

const focus = () => {
  input.value?.focus()
}

defineExpose({ focus })
</script>

<style lang="css" scoped>
input[readonly] {
  @apply bg-gray-200 dark:bg-gray-900 text-gray-400 dark:text-gray-600 focus:ring-0 focus:border-none;
}
</style>
