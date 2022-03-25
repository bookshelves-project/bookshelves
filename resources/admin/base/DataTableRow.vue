<template>
  <tr :class="{ 'bg-gray-100 dark:bg-gray-800': modelValue }">
    <td v-if="canSelect" class="relative w-12 px-6 sm:w-16 sm:px-8">
      <!-- Selected row marker, only show when row is selected. -->
      <div
        v-if="modelValue"
        class="absolute inset-y-0 left-0 w-0.5 bg-primary-600 dark:bg-primary-500"
      ></div>

      <input
        type="checkbox"
        class="absolute left-4 top-1/2 -mt-2 h-5 w-5 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-600 text-primary-600 focus:ring-primary-500 sm:left-6"
        :checked="modelValue"
        @change="change"
        @click.stop
      />
    </td>
    <td
      v-for="column in columns"
      :key="column.field"
      :class="{
        'hidden lg:table-cell': !column.main && column.field !== 'row-action',
      }"
      class="whitespace-nowrap px-3 py-4 text-base text-gray-800 dark:text-gray-200"
    >
      <div
        class="flex items-center"
        :class="{
          'justify-end': column.numeric,
          'justify-center': column.centered,
        }"
      >
        <slot
          :name="`field:${column.field}`"
          :row="item"
          :value="getValue(column)"
        >
          <component
            :is="`${column.type}-field`"
            v-if="column.type && hasValue(column)"
            :field="column.field"
            :value="getValue(column)"
            v-bind="column.props"
          />
          <span v-else class="group inline-flex space-x-2 truncate">
            {{ getValue(column) }}
          </span>
        </slot>
      </div>
    </td>
  </tr>
</template>

<script lang="ts" setup>
import { PropType, provide } from 'vue'
import { Column } from '@admin/types/data-table'
import get from 'lodash/get'

const props = defineProps({
  modelValue: Boolean,
  canSelect: Boolean,
  columns: Array as PropType<Column[]>,
  item: {
    type: Object as PropType<{ [key: string]: any }>,
    required: true,
  },
})

const emit = defineEmits(['select'])

provide('item', props.item)

const getValue = (c: Column) => {
  return get(props.item, c.source || c.field)
}

const hasValue = (c: Column) => {
  return getValue(c) !== undefined && getValue(c) !== null
}

const change = (e: Event) => {
  emit('select', (e.target as HTMLInputElement).checked)
}
</script>
