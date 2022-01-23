<template>
  <base-button
    v-if="item"
    type="button"
    icon="trash"
    variant="danger"
    :hide-label="hideLabel"
    @click="confirm"
  >
    {{ $t('Delete') }}
  </base-button>

  <!-- Delete Account Confirmation Modal -->
  <dialog-modal
    v-if="item"
    method="delete"
    :url="route(`admin.${resource}.destroy`, { id: item.id })"
    :options="{
      preserveScroll: true,
      onSuccess: () => closeModal(),
    }"
    :show="confirming"
    @close="closeModal"
  >
    <template #title>
      {{ $t('admin.confirm.delete_title', { args }) }}
    </template>

    <template #content>
      {{ $t('admin.confirm.delete_message', { args }) }}
    </template>

    <template #footer="{ processing }">
      <base-button outlined type="button" @click="closeModal">
        {{ $t('Cancel') }}
      </base-button>

      <base-button
        variant="danger"
        type="submit"
        class="ml-2"
        :loading="processing"
      >
        {{ $t('Delete') }}
      </base-button>
    </template>
  </dialog-modal>
</template>

<script lang="ts" setup>
  import { useModelToString } from '@admin/features/helpers'
  import { Model } from '@admin/types'
  import { transChoice } from 'matice'
  import { inject, ref } from 'vue'

  defineProps({
    hideLabel: Boolean,
  })

  const resource = inject<string>('resource')
  const item = inject<Model>('item')
  const confirming = ref(false)

  const confirm = () => {
    confirming.value = true
  }

  const closeModal = () => {
    confirming.value = false
  }

  const args = {
    resource: transChoice(`crud.${resource}.name`, 0).toLowerCase(),
    label: useModelToString(resource, item),
  }
</script>
