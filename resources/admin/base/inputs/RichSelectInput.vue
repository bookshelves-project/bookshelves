<template>
  <input-label class="mb-1">{{ getLabel }}</input-label>
  <Multiselect
    v-model="formValue"
    v-bind="{ ...translations }"
    :options="asyncSearch"
    :classes="classes"
    :mode="multiple ? 'tags' : 'single'"
    :value-prop="optionValue"
    :label="optionText"
    :searchable="searchable"
    :min-chars="minChars"
    :create-tag="taggable"
    :placeholder="placeholder"
    :filter-results="!asyncSearch"
    :delay="200"
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
    modelValue: [String, Number, Array],
    multiple: Boolean,
    taggable: Boolean,
    resource: {
      type: String,
      required: true,
    },
    optionText: {
      type: String,
      default: 'name',
    },
    optionValue: {
      type: String,
      default: 'id',
    },
    minChars: Number,
    searchable: Boolean,
    placeholder: String,
  })

  const emit = defineEmits(['update:modelValue'])

  const { getLabel, formValue, getError } = inputSetup(props, emit)

  const translations = computed(() => {
    return getLocale() === 'fr' ? French : {}
  })

  const classes = computed(() => {
    return {
      container:
        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none shadow-sm',
      containerDisabled: 'cursor-default bg-gray-100',
      containerOpen: 'rounded-b-none',
      containerOpenTop: 'rounded-t-none',
      containerActive: 'ring ring-green-500 ring-opacity-30',
      singleLabel:
        'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
      multipleLabel:
        'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
      search:
        'h-full w-full absolute inset-0 outline-none appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5',
      tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2',
      tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
      tagDisabled: 'pr-2 !bg-gray-400 text-white',
      tagRemove:
        'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
      tagRemoveIcon:
        'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
      tagsSearchWrapper:
        'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
      tagsSearch:
        'absolute inset-0 border-0 outline-none appearance-none p-0 text-base font-sans box-border w-full',
      tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
      placeholder:
        'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400',
      caret:
        'bg-multiselect-caret bg-center bg-no-repeat w-5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none',
      caretOpen: 'rotate-180 pointer-events-auto',
      clear:
        'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
      clearIcon:
        'bg-multiselect-remove bg-center bg-no-repeat w-4 h-4 py-px box-content inline-block',
      spinner:
        'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
      dropdown:
        'absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
      dropdownTop:
        '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
      dropdownHidden: 'hidden',
      options: 'flex flex-col p-0 m-0 list-none',
      optionsTop: 'flex-col-reverse',
      option:
        'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
      optionPointed: 'text-gray-800 bg-gray-100',
      optionSelected: 'text-white bg-green-500',
      optionDisabled: 'text-gray-300 cursor-not-allowed',
      optionSelectedPointed: 'text-white bg-green-500 opacity-90',
      optionSelectedDisabled:
        'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
      noOptions: 'py-2 px-3 text-gray-600 bg-white',
      noResults: 'py-2 px-3 text-gray-600 bg-white',
      fakeInput:
        'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
      spacer: 'h-9 py-px box-content',
    }
  })

  const asyncSearch = computed(() => {
    return async (query: string) => {
      if (query) {
        const { data } = await axios.get<{ data: any }>(
          `${route(`admin.${props.resource}`)}?filter[q]=${query}`
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
        `${route(`admin.${props.resource}`)}?filter[id]=${value.join(',')}`
      )
      return data.data
    }
  })
</script>
