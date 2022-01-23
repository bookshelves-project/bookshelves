<template>
  <input-label class="mb-1">{{ getLabel }}</input-label>
  <Multiselect
    v-model="formValue"
    v-bind="{ ...translations }"
    :options="type === 'relation' ? asyncSearch : getChoices"
    :mode="multiple ? 'tags' : 'single'"
    :value-prop="optionValue"
    :label="optionText"
    :searchable="searchable"
    :min-chars="minChars"
    :create-tag="taggable"
    :placeholder="placeholder"
    :filter-results="type === 'relation' && !asyncSearch"
    :delay="type === 'relation' ? 200 : -1"
  >
    <template #singlelabel="labelProps">
      <slot name="singlelabel" :value="labelProps.value"></slot>
    </template>

    <template #option="{ option }">
      <slot name="option" :option="option"></slot>
    </template>

    <template #tag="{ option, handleTagRemove, disabled }">
      <slot
        name="tag"
        :option="option"
        :handleTagRemove="handleTagRemove"
        :disabled="disabled"
      ></slot>
    </template>
  </Multiselect>
  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
</template>

<script lang="ts" setup>
import { choicesProps, choicesSetup } from '@admin/mixins/choices'
import { inputProps, inputSetup } from '@admin/mixins/input'
import { computed } from 'vue'
import Multiselect from '@vueform/multiselect'
import route from 'ziggy-js'
import axios from 'axios'
import French from '@admin/lang/multiselect.fr'
import { getLocale } from 'matice'
import isEmpty from 'lodash/isEmpty'

const props = defineProps({
  ...inputProps,
  ...choicesProps,
  modelValue: [String, Number, Array],
  type: {
    type: String,
    default: 'relation',
    validator: (v: string) => ['relation', 'choices'].includes(v),
  },
  multiple: Boolean,
  taggable: Boolean,
  resource: {
    type: String,
    required: false,
  },
  optionText: {
    type: String,
    default: 'name',
  },
  optionValue: {
    type: String,
    default: 'id',
  },
  customSearch: {
    type: String,
    default: 'q',
  },
  minChars: Number,
  searchable: Boolean,
  placeholder: String,
})

const emit = defineEmits(['update:modelValue'])

const { getChoices } = choicesSetup(props, emit)
const { getLabel, formValue, getError } = inputSetup(props, emit)

const translations = computed(() => {
  return getLocale() === 'fr' ? French : {}
})

const asyncSearch = computed(() => {
  return async (query: string) => {
    if (query) {
      const { data } = await axios.get<{ data: any }>(
        `${route(`admin.${props.resource}`)}?filter[${
          props.customSearch
        }]=${query}`
      )

      return data.data
    }

    if (props.taggable) {
      return formValue.value
    }

    const value = props.multiple ? (formValue.value as []) : [formValue.value]

    if (isEmpty(value)) {
      return []
    }

    const { data } = await axios.get<{ data: any }>(
      `${route(`admin.${props.resource}`)}?filter[${
        props.optionValue
      }]=${value.join(',')}`
    )
    return data.data
  }
})
</script>
