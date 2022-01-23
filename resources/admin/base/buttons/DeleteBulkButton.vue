<template>
  <base-button
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
    method="delete"
    :url="route(`admin.${resource}.bulk.destroy`)"
    :options="{
      preserveState: false,
      onSuccess: () => closeModal(),
    }"
    :data="{
      ids: selected,
    }"
    :show="confirming"
    @close="closeModal"
  >
    <template #title>
      {{ $t('admin.confirm.delete_many_title', { args }) }}
    </template>

    <template #content>
      {{ $t('admin.confirm.delete_many_message', { args }) }}
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
  import { transChoice } from 'matice'
  import { computed, inject, ref } from 'vue'

  const props = defineProps({
    hideLabel: Boolean,
    selected: Array,
  })

  const resource = inject<string>('resource')
  const confirming = ref(false)

  const confirm = () => {
    confirming.value = true
  }

  const closeModal = () => {
    confirming.value = false
  }

  const args = computed(() => {
    return {
      resource: transChoice(
        `crud.${resource}.name`,
        props.selected?.length || 0
      ).toLowerCase(),
      count: props.selected?.length,
    }
  })
</script>
