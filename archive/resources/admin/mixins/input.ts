import { useUniqueId } from '@admin/features/helpers'
import { transAttribute } from '@admin/plugins/translations'
import last from 'lodash/last'
import get from 'lodash/get'
import set from 'lodash/set'
import { computed, ExtractPropTypes, inject, watch } from 'vue'

export const inputProps = {
  label: String,
  labelKey: String,
  source: {
    type: String,
    required: true,
  },
  targetSource: String,
  hint: String,
  getter: Function,
}

export const inputSetup = (
  props: Readonly<ExtractPropTypes<typeof inputProps> & { modelValue?: any }>,
  emit: (event: 'update:modelValue', ...args: any[]) => void
) => {
  const id = useUniqueId()
  const form = inject<null | { initial; data; errors }>('form', null)

  const getLabel = computed(() => {
    if (!props.label) {
      return transAttribute(
        last<string>((props.labelKey || props.source!).split('.')) || ''
      )
    }
    return props.label
  })

  const getName = computed(() => {
    return props.source
  })

  const getErrors = computed(() => {
    return form!.errors
  })

  const getError = computed(() => {
    if (form!.errors && form!.errors[props.source!]) {
      return form!.errors[props.source!]
    }
    return ''
  })

  const hasError = computed(() => {
    return !!getError.value
  })

  const getInitialValue = computed(() => {
    if (!form || !form.initial) return props.modelValue
    return props.getter
      ? props.getter(form.initial)
      : get(form.initial, props.source!)
  })

  const formValue = computed({
    get: () => get(form!.data, props.source!),
    set: (val) => {
      set(form!.data, props.source!, val)
      emit('update:modelValue', val)
    },
  })

  if (form && 'modelValue' in props) {
    set(form.data, props.source!, getInitialValue.value)
    emit('update:modelValue', getInitialValue.value)

    watch(
      () => props.modelValue,
      (val) => {
        formValue.value = val
      }
    )
  }

  return {
    id,
    getLabel,
    getName,
    hasError,
    getError,
    getErrors,
    getInitialValue,
    formValue,
    form,
  }
}
