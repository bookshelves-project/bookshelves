<template>
  <base-button
    type="button"
    icon="lock-closed"
    variant="warning"
    :loading="form.processing"
    :hide-label="hideLabel"
    @click="submit"
  >
    {{ $t('Impersonate') }}
  </base-button>
</template>

<script lang="ts" setup>
  import { Model } from '@admin/types'
  import { useForm } from '@inertiajs/inertia-vue3'
  import { inject } from 'vue'
  import route from 'ziggy-js'

  defineProps({
    hideLabel: Boolean,
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
