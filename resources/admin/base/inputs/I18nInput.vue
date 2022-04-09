<template>
  <base-input>
    <input-label :for="id" class="mb-1" :value="getLabel" />
    <div class="grid md:grid-cols-2 gap-4">
      <span v-for="(item, lang) in formValue" :key="lang" class="relative">
        <div class="mt-1 flex rounded-md shadow-sm">
          <span
            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm uppercase dark:border-gray-600 dark:bg-gray-600 dark:text-gray-100"
          >
            {{ lang }}
          </span>
          <input
            v-bind="$attrs"
            :id="id"
            ref="input"
            v-model="formValue[lang]"
            :name="getName"
            class="flex-1 min-w-0 block w-full px-3 py-2 !rounded-none !rounded-r-md focus:ring-primary-500 focus:border-primary-500 shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
            :class="{ 'form-invalid': hasError }"
          />
        </div>
      </span>
    </div>
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
