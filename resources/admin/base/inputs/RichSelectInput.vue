<script lang="ts" setup>
import { inputProps, inputSetup } from '@admin/composables/input'
import { computed, ref } from 'vue'
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

let newTagsList = ref([])

const emit = defineEmits(['update:modelValue'])

const { getLabel, formValue, getError } = inputSetup(props, emit)

const translations = computed(() => {
  return getLocale() === 'fr' ? French : {}
})

const isNew = (option: any) => {
  let list = option as never

  if (newTagsList.value.includes(list[props.optionText])) {
    return classes.value.tagOnCreate
  }

  return classes.value.tag
}

const classes = computed(() => {
  return {
    tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
    tagOnCreate:
      'bg-orange-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
    tagRemove:
      'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
    tagRemoveIcon:
      'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
  }
})

const onAddTag = (searchQuery: never) => {
  newTagsList.value.push(searchQuery)
  return
}

const asyncSearch = computed(() => {
  return async (query: string) => {
    if (query) {
      console.log(`${route(`admin.${props.resource}`)}?filter[q]=${query}`)

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

<template>
  <base-input>
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
      @tag="onAddTag"
    >
      <template #singlelabel="labelProps">
        <slot name="singlelabel" :value="labelProps.value"></slot>
      </template>

      <template #option="{ option }">
        <slot name="option" :option="option"></slot>
      </template>

      <template #tag="{ option, handleTagRemove, disabled }">
        <span :class="isNew(option)">
          {{ option[optionText] }}
          <span
            v-if="!disabled"
            :class="classes.tagRemove"
            @click="handleTagRemove(option, $event)"
          >
            <span :class="classes.tagRemoveIcon"></span>
          </span>
        </span>
      </template>
    </Multiselect>
    <span class="text-sm italic">
      Try to type any {{ resource }} to find existing {{ resource }}, if it not
      present click on it to create it.
    </span>
    <input-error :message="getError" class="mt-2" />
    <input-hint :message="hint" class="mt-2" />
  </base-input>
</template>

<style lang="css" scoped>
.multiselect {
  @apply dark:bg-gray-700 border-gray-300 dark:border-gray-600;
}
.multiselect :deep(.multiselect-tags-search) {
  position: absolute;
  top: -0.2rem;
  padding: 0;
  height: 2rem;
  @apply dark:bg-gray-700;
}
.multiselect :deep(.multiselect-search) {
  @apply dark:bg-gray-700;
  padding: 0.4rem 0.8rem;
}

.multiselect :deep(.multiselect-dropdown) {
  @apply dark:bg-gray-800 dark:border-gray-600 scrollbar-thin;
}
.multiselect :deep(.multiselect-dropdown) .is-pointed {
  @apply dark:bg-gray-600 dark:text-white;
}
</style>

<style src="@vueform/multiselect/themes/default.css"></style>
