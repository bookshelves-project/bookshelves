<template>
  <flatpickr-input-wrapper
    :options="config"
    :model-value="modelValue ? modelValue.split(',') : ''"
  />
</template>

<script lang="ts" setup>
  import { computed } from 'vue'
  import { format } from 'date-fns'
  import { Options } from 'flatpickr/dist/types/options'

  defineProps({
    modelValue: String,
  })

  const emit = defineEmits(['update:modelValue'])

  const config = computed((): Options => {
    return {
      dateFormat: 'Y-m-d',
      mode: 'range',
      onChange: (dates: Date[]) => {
        emit(
          'update:modelValue',
          dates.length === 2
            ? dates.map((d) => format(d, 'yyyy-MM-dd')).join(',')
            : null
        )
      },
    }
  })
</script>
