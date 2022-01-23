<template>
  <input-label :for="id" class="mb-1" :value="getLabel" />
  <flatpickr-input-wrapper
    v-bind="$attrs"
    :id="id"
    class="block w-full"
    :class="{ 'form-invalid': hasError }"
    :options="config"
    :model-value="formValue"
  />
  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
</template>

<script lang="ts" setup>
  import { computed, PropType } from 'vue'
  import { inputProps, inputSetup } from '@admin/mixins/input'
  import { Options } from 'flatpickr/dist/types/options'

  const props = defineProps({
    ...inputProps,
    modelValue: [String, Date],
    options: Object as PropType<Options>,
  })

  const emit = defineEmits(['update:modelValue'])

  const { getLabel, formValue, getError, hasError, id } = inputSetup(
    props,
    emit
  )

  const config = computed((): Options => {
    const config: Options = props.options || {
      enableTime: true,
      dateFormat: 'Y-m-d H:i',
    }
    if (!config.onChange) {
      config.onChange = (dates: Date[]) => {
        formValue.value = dates[0]
      }
    }
    return config
  })
</script>
