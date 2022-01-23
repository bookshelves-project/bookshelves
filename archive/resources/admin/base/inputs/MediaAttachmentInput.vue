<template>
  <div>
    <!-- <input-label class="mb-1" :value="getLabel" />
    <media-library-attachment
      :name="name"
      :translations="translations"
      :initial-value="formValue"
      :validation-rules="{
        accept,
        maxSizeInKB,
      }"
      :validation-errors="getErrors"
      :max-items="maxItems"
      :multiple="multiple"
      @change="onChange"
      @is-ready-to-submit-change="$emit('uploading', !$event)"
    />
    <input-hint :message="hint" class="mt-2" /> -->
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { inputProps, inputSetup } from '@admin/mixins/input'
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'
// import { MediaLibraryAttachment } from '@spatie/media-library-pro-vue3-attachment'
import French from '@admin/lang/media.fr'
import { getLocale } from 'matice'

const props = defineProps({
  ...inputProps,
  modelValue: Array,
  name: {
    type: String,
    required: true,
  },
  accept: Array,
  maxSizeInKB: {
    type: Number,
    default: 10240,
  },
  maxItems: Number,
  multiple: Boolean,
})

const emit = defineEmits(['update:modelValue', 'uploading'])

const { getLabel, formValue, getErrors } = inputSetup(props, emit)

const translations = computed(() => {
  return getLocale() === 'fr' ? French : {}
})

// const onChange = (media: { [uuid: string]: MediaLibrary.MediaAttributes }) => {
//   /**
//    * HACK : on s'assure que la valeur est un POJO (i.e sans proxy)
//    * Notamment le cas pour un upload dans un disclosure en mode update
//    */
//   formValue.value = JSON.parse(JSON.stringify(media))
// }
</script>
