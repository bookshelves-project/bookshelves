<template>
  <div class="relative">
    <input v-bind="$attrs" ref="fpInput" type="text" />
    <button
      v-if="modelValue"
      type="button"
      class="absolute top-1/2 right-3 transform -translate-y-1/2 opacity-50"
      @click="clear"
    >
      <x-icon class="h-5 w-5" />
    </button>
  </div>
</template>

<script lang="ts" setup>
  import { onBeforeUnmount, onMounted, PropType, Ref, ref } from 'vue'
  import 'flatpickr/dist/flatpickr.min.css'
  import flatpickr from 'flatpickr'
  import { Instance as FlatpickrInstance } from 'flatpickr/dist/types/instance'
  import { Options as FlatpickrOptions } from 'flatpickr/dist/types/options'
  import { French } from 'flatpickr/dist/l10n/fr.js'
  import { getLocale } from 'matice'

  const props = defineProps({
    modelValue: [String, Number, Date, Array],
    options: Object as PropType<FlatpickrOptions>,
  })

  const fp: Ref<FlatpickrInstance | null> = ref(null)
  const fpInput: Ref<HTMLInputElement | null> = ref(null)

  onMounted(() => {
    if (fp.value) return

    let config: FlatpickrOptions = props.options || {
      enableTime: true,
      dateFormat: 'Y-m-d H:i',
    }

    if (getLocale() === 'fr') {
      config.locale = French
    }

    fp.value = flatpickr(fpInput.value as Node, config)

    if (props.modelValue) {
      fp.value.setDate(props.modelValue as string, true)
    }
  })
  onBeforeUnmount(() => {
    if (fp.value) {
      fp.value?.destroy()
      fp.value = null
    }
  })

  const clear = () => {
    fp.value?.clear()
  }
</script>
