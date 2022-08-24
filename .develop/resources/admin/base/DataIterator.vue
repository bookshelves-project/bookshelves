<script setup lang="ts">
import type { PropType } from 'vue'
import type { Model, PaginatedData } from '@admin/types'

const props = defineProps({
  source: {
    type: Object as PropType<PaginatedData<Model>>,
    required: true,
  },
  hideFooter: Boolean,
  sizeOptions: {
    type: Array as PropType<number[]>,
    default: () => [5, 10, 15, 32, 50, 100],
  },
})

const emit = defineEmits(['page-change'])

const onPageChange = (page: number) => {
  emit('page-change', {
    page,
    size: props.source.meta.per_page,
  })
}

const onSizeChange = (e: Event) => {
  emit('page-change', {
    page: 1,
    size: parseInt((e.target as HTMLInputElement).value, 10),
  })
}
</script>

<template>
  <div
    v-if="source && !hideFooter"
    class="flex flex-col sm:flex-row mt-3 gap-4"
  >
    <div class="flex flex-row justify-center sm:justify-start items-center">
      <select
        :value="source.meta.per_page"
        class="mr-2 text-base text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
        @input="onSizeChange"
      >
        <option
          v-for="(count, i) in sizeOptions"
          :key="i"
          :value="count"
        >
          {{ count }}
        </option>
      </select>
      <label class="text-base text-gray-700 dark:text-gray-400">{{
        $t('admin.data-table.rows_per_page_text')
      }}</label>
    </div>
    <div
      v-if="source.meta.total"
      class="flex flex-row items-center ml-auto"
    >
      <span
        class="hidden sm:inline-block text-base text-gray-700 dark:text-gray-400"
      >{{
        $t('admin.data-table.page_text', {
          args: {
            start: source.meta.from,
            end: source.meta.to,
            total: source.meta.total,
          },
        })
      }}</span>
      <pagination
        class="ml-2"
        :current-page="source.meta.current_page"
        :size="source.meta.per_page"
        :total="source.meta.total"
        @page-change="onPageChange"
      />
    </div>
  </div>
</template>
