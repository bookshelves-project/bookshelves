<template>
  <input-label class="mb-1">{{ getLabel }}</input-label>
  <div class="flex" :class="{ 'flex-col gap-1': stacked, 'gap-4': !stacked }">
    <label
      v-for="option in getChoices"
      :key="option.value"
      class="flex items-center text-sm whitespace-nowrap"
    >
      <input
        type="radio"
        :name="getName"
        :value="option.value"
        class="checked:bg-primary-500 mr-2"
        :checked="formValue === option.value"
        @input="onInput"
      />
      {{ option.text }}
    </label>
  </div>
  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
</template>

<script lang="ts" setup>
  import { choicesProps, choicesSetup } from '@admin/mixins/choices'

  const props = defineProps({
    ...choicesProps,
    modelValue: String,
    stacked: Boolean,
  })

  const emit = defineEmits(['update:modelValue'])

  const { getLabel, formValue, getError, getName, getChoices } = choicesSetup(
    props,
    emit
  )

  const onInput = (e: Event) => {
    formValue.value = (e.target as HTMLInputElement).value
  }
</script>
