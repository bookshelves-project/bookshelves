import { usePage } from '@inertiajs/inertia-vue3'
import axios from 'axios'
import type { ExtractPropTypes } from 'vue'
import { computed, ref, watch } from 'vue'
import route from 'ziggy-js'

export const referenceProps = {
  modelValue: [String, Number, Array],
  resource: {
    type: String,
    required: true,
  },
}

export const referenceSetup = (
  props: Readonly<ExtractPropTypes<typeof referenceProps>>,
  emit: (event: 'update:modelValue', ...args: any[]) => void,
) => {
  const choices = ref([])

  const fetchList = async () => {
    const { data } = await axios.get<{ data: any }>(
      route(`admin.${props.resource}.fetch`),
    )

    choices.value = data.data
    // @ts-expect-error
    if (props.i18n) {
      const locale = usePage().props.value.locale
      choices.value.forEach((choice) => {
        // @ts-expect-error
        choice[props.optionText] = choice[props.optionText][locale]
      })
    }
  }

  watch(
    () => props.resource,
    () => fetchList(),
    { immediate: true },
  )

  const value = computed({
    get: () => props.modelValue,
    set: val => emit('update:modelValue', val),
  })

  return {
    choices,
    value,
  }
}
