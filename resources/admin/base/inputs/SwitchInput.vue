<template>
  <switch-toggle v-model="formValue" :label="getLabel" :name="getName" />
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

  const { getLabel, formValue, getError, getName } = inputSetup(props, emit)
</script>
