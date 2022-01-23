<template>
  <div class="flex">
    <image-field
      v-if="preview && hasFile"
      :value="getInitialValue"
      class="mr-4"
    />
    <div>
      <input-label :for="id" class="mb-1" :value="getLabel" />
      <input
        v-bind="$attrs"
        :id="id"
        :name="getName"
        class="block w-full"
        :class="{ 'form-invalid': hasError }"
        type="file"
        :multiple="multiple"
        @change="onFileChange"
      />
      <input-error :message="getError" class="mt-2" />
      <input-hint :message="hint" class="mt-2" />
      <label v-if="hasFile" class="flex items-center mt-2">
        <input type="checkbox" @change="onChange" />
        <span class="ml-2 text-sm text-gray-600">{{
          $t('admin.actions.delete')
        }}</span>
      </label>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { inputProps, inputSetup } from '@admin/mixins/input'
  import set from 'lodash/set'
  import isEmpty from 'lodash/isEmpty'
  import { computed } from 'vue'

  const props = defineProps({
    ...inputProps,
    fileSource: String,
    deleteSource: String,
    delete: Boolean,
    multiple: Boolean,
    preview: Boolean,
  })

  const emit = defineEmits(['update:modelValue'])

  const { getLabel, getError, hasError, id, getName, getInitialValue, form } =
    inputSetup(props, emit)

  const hasFile = computed(() => {
    return !isEmpty(getInitialValue.value)
  })

  const onChange = (e: Event) => {
    set(form!.data, props.deleteSource!, (e.target as HTMLInputElement).checked)
  }

  const onFileChange = (e: Event & { dataTransfer?: DataTransfer }) => {
    const files = (e.target as HTMLInputElement).files || e.dataTransfer?.files
    if (files?.length) {
      set(form!.data, props.fileSource!, props.multiple ? files : files[0])
    }
  }
</script>
