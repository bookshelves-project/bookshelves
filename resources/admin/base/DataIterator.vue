<template>
  <div
    v-if="source && !hideFooter"
    class="flex flex-col sm:flex-row mt-6 gap-4"
  >
    <div class="flex flex-row justify-center sm:justify-start items-center">
      <select
        :value="source.meta.per_page"
        class="mr-2"
        @input="onPerPageChange"
      >
        <option v-for="(count, i) in perPageOptions" :key="i" :value="count">
          {{ count }}
        </option>
      </select>
      <label>{{ $t('admin.data-table.rows_per_page_text') }}</label>
    </div>
    <div v-if="source.meta.total" class="flex flex-row items-center ml-auto">
      <span class="hidden sm:inline-block">{{
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
        :per-page="source.meta.per_page"
        :total="source.meta.total"
        @page-change="onPageChange"
      />
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { Model, PaginatedData } from '@admin/types'

  const props = defineProps({
    source: {
      type: Object as PropType<PaginatedData<Model>>,
      required: true,
    },
    hideFooter: Boolean,
    perPageOptions: {
      type: Array as PropType<number[]>,
      default: () => [5, 10, 15, 30, 50, 100],
    },
  })

  const emit = defineEmits(['page-change'])

  const onPageChange = (page: number) => {
    emit('page-change', { page, perPage: props.source.meta.per_page })
  }

  const onPerPageChange = (e: Event) => {
    emit('page-change', {
      page: 1,
      perPage: parseInt((e.target as HTMLInputElement).value, 10),
    })
  }
</script>
