<template>
  <input-label
    v-if="getLabel"
    :for="id"
    class="block text-sm font-medium text-gray-700 mb-1"
    :value="getLabel"
  />
  <textarea
    v-if="multiline"
    v-bind="$attrs"
    :id="id"
    ref="input"
    v-model="formValue"
    :name="getName"
    class="block w-full"
    :class="{ 'form-invalid': hasError }"
  />
  <input
    v-else
    v-bind="$attrs"
    :id="id"
    ref="input"
    v-model="formValue"
    :name="getName"
    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
    :class="{ 'form-invalid': hasError }"
  />
  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue'
import { inputProps, inputSetup } from '@admin/mixins/input'

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
