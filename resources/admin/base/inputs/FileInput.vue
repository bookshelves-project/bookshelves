<template>
  <div class="flex items-center space-x-6">
    <div class="shrink-0">
      <image-field
        v-if="preview && hasFile"
        :value="getInitialValue"
        :preview="previewAttr"
      />
    </div>
    <div>
      <label :for="id" class="block" :value="getLabel">
        <span class="sr-only">Choose file</span>
        <input
          v-bind="$attrs"
          :id="id"
          :name="getName"
          type="file"
          :class="{ 'form-invalid': hasError }"
          class="block w-full text-base text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-base file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
          :multiple="multiple"
          @change="onFileChange"
        />
        <input-error :message="getError" class="mt-2" />
        <input-hint :message="hint" class="mt-2" />
      </label>
      <label v-if="hasFile" class="flex items-center mt-2">
        <input type="checkbox" @change="onChange" />
        <span class="ml-2 text-base text-gray-600">{{
          $t('admin.actions.delete')
        }}</span>
      </label>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { inputProps, inputSetup } from '@admin/composables/input'
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
    previewAttr: {
      type: String,
      default: 'preview_url',
    },
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
