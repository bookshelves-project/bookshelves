import axios from 'axios'
import { computed, ExtractPropTypes, ref, watch } from 'vue'
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
  emit: (event: 'update:modelValue', ...args: any[]) => void
) => {
  const choices = ref([])

  const fetchList = async () => {
    const { data } = await axios.get<{ data: any }>(
      route(`admin.${props.resource}`)
    )
    choices.value = data.data
  }

  watch(
    () => props.resource,
    () => fetchList(),
    { immediate: true }
  )

  const value = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val),
  })

  return { choices, value }
}
