<script lang="ts" setup>
import type { Model } from '@admin/types'
import { useForm } from '@inertiajs/inertia-vue3'
import { inject } from 'vue'
import route from 'ziggy-js'

defineProps({
  hideLabel: Boolean,
  // eslint-disable-next-line vue/no-reserved-props
  key: {
    type: String,
    default: 'id',
  },
})

const resource = inject<string>('resource')
const item = inject<Model>('item')

const form = useForm({})

const submit = () => {
  form.post(route(`admin.${resource}.impersonate`, { id: item!.id }), {
    preserveScroll: true,
  })
}
</script>

<template>
  <base-button
    icon="lock-closed"
    variant="invisible"
    :loading="form.processing"
    :hide-label="hideLabel"
    @click="submit"
  >
    {{ $t('Impersonate') }}
  </base-button>
</template>
