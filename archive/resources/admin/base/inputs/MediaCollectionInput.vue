<template>
  <div>
    <!-- <input-label class="mb-1" :value="getLabel" />
    <media-library-collection
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
    >
      <template
        #fields="{
          getCustomPropertyInputProps,
          getCustomPropertyInputListeners,
          getCustomPropertyInputErrors,
          getNameInputProps,
          getNameInputListeners,
          getNameInputErrors,
        }"
      >
        <div class="media-library-properties">
          <div class="media-library-field">
            <label class="media-library-label">
              {{ $t('admin.attributes.name') }}
            </label>
            <input
              class="media-library-input"
              v-bind="getNameInputProps()"
              v-on="getNameInputListeners()"
            />
            <p
              v-for="error in getNameInputErrors()"
              :key="error"
              class="media-library-text-error"
            >
              {{ error }}
            </p>
          </div>

          <div
            v-for="(property, i) in customProperties"
            :key="i"
            class="media-library-field"
          >
            <label class="media-library-label">
              {{ $t(`admin.attributes.${property}`) }}
            </label>
            <input
              class="media-library-input"
              v-bind="getCustomPropertyInputProps(property)"
              v-on="getCustomPropertyInputListeners(property)"
            />
            <p
              v-for="error in getCustomPropertyInputErrors(property)"
              :key="error"
              class="media-library-text-error"
            >
              {{ error }}
            </p>
          </div>
        </div>
      </template>
    </media-library-collection>
    <input-hint :message="hint" class="mt-2" /> -->
  </div>
</template>

<script lang="ts" setup>
import { computed, PropType } from 'vue'
import { inputProps, inputSetup } from '@admin/mixins/input'
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'
// import { MediaLibraryCollection } from '@spatie/media-library-pro-vue3-collection'
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
  customProperties: Array as PropType<string[]>,
})

const emit = defineEmits(['update:modelValue', 'uploading'])

// const { getLabel, formValue, getErrors } = inputSetup(props, emit)

// const translations = computed(() => {
//   return getLocale() === 'fr' ? French : {}
// })

// const onChange = (media: { [uuid: string]: MediaLibrary.MediaAttributes }) => {
//   /**
//    * HACK : on s'assure que la valeur est un POJO (i.e sans proxy)
//    * Notamment le cas pour un upload dans un disclosure en mode update
//    */
//   formValue.value = JSON.parse(JSON.stringify(media))
// }
</script>
