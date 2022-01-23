<template>
  <form @submit.prevent="onSubmit">
    <slot :processing="processing" :recently-successful="recentlySuccessful" />
  </form>
</template>

<script lang="ts" setup>
  import { inject, provide, ref, reactive } from 'vue'
  import { Inertia, Method } from '@inertiajs/inertia'

  const props = defineProps({
    transform: Function,
    method: {
      type: String,
      required: true,
    },
    url: {
      type: String,
      required: true,
    },
    options: Object,
    data: Object,
    disableSubmit: Boolean,
    item: Object,
  })

  const item = inject<any>('item', null)

  const processing = ref(false)
  const recentlySuccessful = ref(false)

  let recentlySuccessfulTimeoutId: ReturnType<typeof setTimeout>

  const form = reactive({
    initial: props.item || item,
    data: {},
    errors: {},
  })
  provide('form', form)

  const onSubmit = () => {
    if (!props.disableSubmit) {
      submit()
    }
  }

  const submit = async (data = {}) => {
    Inertia.visit(props.url, {
      method: props.method as Method,
      data: {
        ...props.data,
        ...data,
        ...(props.transform ? props.transform(form.data) : form.data),
      },
      preserveState: true,
      ...props.options,
      onBefore: (visit) => {
        recentlySuccessful.value = false
        clearTimeout(recentlySuccessfulTimeoutId)

        if (props.options?.onBefore) {
          return props.options.onBefore(visit)
        }
      },
      onStart: (visit) => {
        processing.value = true

        if (props.options?.onStart) {
          return props.options.onStart(visit)
        }
      },
      onSuccess: (page) => {
        processing.value = false
        recentlySuccessful.value = true
        recentlySuccessfulTimeoutId = setTimeout(
          () => (recentlySuccessful.value = false),
          2000
        )

        if (props.options?.onSuccess) {
          return props.options.onSuccess(page)
        }
      },
      onError: (errors) => {
        processing.value = false
        form.errors = { ...errors }

        if (props.options?.onError) {
          return props.options.onError(errors)
        }
      },
      onFinish: () => {
        processing.value = false

        if (props.options?.onFinish) {
          return props.options.onFinish()
        }
      },
    })
  }

  defineExpose({ submit })
</script>
