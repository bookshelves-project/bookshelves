<template>
  <input-label class="mb-1" :value="getLabel" />
  <disclosure
    v-model="formValue"
    :item-text="itemText"
    editable
    :new-item="newItem"
    :group="source"
  >
    <template #default="{ index }">
      <slot :index="index" />
    </template>
  </disclosure>
</template>

<script lang="ts" setup>
  import { inputProps, inputSetup } from '@admin/mixins/input'

  const props = defineProps({
    ...inputProps,
    modelValue: Array,
    itemText: String,
    newItem: Object,
  })

  const emit = defineEmits(['update:modelValue'])

  const { getLabel, formValue } = inputSetup(props, emit)
</script>
