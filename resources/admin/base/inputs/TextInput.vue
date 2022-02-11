<template>
  <input-label :for="id" class="mb-1" :value="getLabel" />
  <textarea
    v-if="multiline"
    v-bind="$attrs"
    :id="id"
    ref="input"
    v-model="formValue"
    :name="getName"
    rows="4"
    class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm border-gray-300 rounded-md scrollbar-thin"
    :class="{ 'form-invalid': hasError }"
  />
  <input
    v-else
    v-bind="$attrs"
    :id="id"
    ref="input"
    v-model="formValue"
    :name="getName"
    class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm border-gray-300 rounded-md"
    :class="{ 'form-invalid': hasError }"
  />
  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
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
