<template>
  <tr>
    <td v-if="canSelect" class="px-4 py-4 border-t text-center">
      <input
        :checked="modelValue"
        class="w-6 h-6"
        type="checkbox"
        @change="change"
        @click.stop
      />
    </td>
    <td
      v-for="column in columns"
      :key="column.field"
      class="border-t px-6 py-4"
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
          <span v-else>
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
