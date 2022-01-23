<template>
  <input-label :for="id" class="mb-1" :value="getLabel" />
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
    class="block w-full"
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
