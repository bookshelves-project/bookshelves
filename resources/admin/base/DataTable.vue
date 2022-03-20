<template>
  <div>
    <div
      v-if="source && !hideHeader"
      class="flex flex-col sm:flex-row gap-4 mb-6"
    >
      <div v-if="!disableSearch" class="w-full sm:w-96">
        <div class="relative">
          <input
            v-model="form.filter.q"
            type="text"
            class="w-full"
            :placeholder="$t('admin.actions.search')"
            @input="onFilter"
          />
          <search-icon
            class="h-5 w-5 absolute top-1/2 right-4 transform -translate-y-1/2 opacity-50"
          />
        </div>
      </div>
      <div class="ml-auto flex items-center gap-2">
        <div
          v-if="hasSelectedItems && !!$slots['bulk-actions']"
          class="flex flex-row items-center"
        >
          <span class="mr-4">
            {{
              $t('admin.data-table.selected', {
                args: { count: selected.length },
              })
            }}
          </span>

          <slot name="bulk-actions" :selected="selected" />
        </div>
        <slot v-else name="actions" />
      </div>
    </div>
    <div class="mt-8 flex flex-col">
      <div class="min-w-full py-2 align-middle">
        <div
          class="relative overflow-auto shadow scrollbar-thin scrollbar-thumb-primary-200 scrollbar-track-gray-100 ring-1 ring-black ring-opacity-5 md:rounded-lg"
        >
          <table
            class="min-w-full table-fixed divide-y divide-gray-300 dark:divide-gray-700"
          >
            <thead>
              <tr>
                <th
                  v-if="!!$slots['bulk-actions']"
                  class="px-4 pt-6 pb-4 border-b text-center"
                >
                  <input
                    :checked="selectAll"
                    type="checkbox"
                    class="w-5 h-5"
                    @change="onSelectAll"
                  />
                </th>
                <th
                  v-for="column in getColumns"
                  :key="column.field"
                  class="px-3 py-4 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                  :style="column.width ? `width: ${column.width}px` : ''"
                  :class="{
                    'text-right': column.numeric,
                    'text-center': column.centered,
                    'border-b': column.field === sortBy,
                    'hover:border-b cursor-pointer': column.sortable,
                    'hidden lg:table-cell':
                      !column.main && column.field !== 'row-action',
                  }"
                  @click="onSort(column)"
                >
                  <div
                    v-if="column.sortable"
                    type="button"
                    class="inline-flex items-center font-semibold hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors duration-75 p-2 rounded-md whitespace-nowrap"
                    :class="{
                      'underline underline-offset-4': column.sortable,
                    }"
                  >
                    <span :class="{ 'order-2': column.numeric }">
                      {{ column.label || $ta(column.field) }}
                    </span>
                    <component
                      :is="`${sortDesc ? 'arrow-down' : 'arrow-up'}-icon`"
                      v-if="column.field === sortBy"
                      class="h-4 w-4"
                      :class="{
                        'order-1 mr-2': column.numeric,
                        'ml-2': !column.numeric,
                      }"
                    />
                  </div>
                  <div
                    v-else-if="column.field === 'row-action'"
                    class="text-center"
                  >
                    Actions
                  </div>
                  <span v-else>
                    {{ column.label || $ta(column.field) }}
                  </span>
                </th>
              </tr>
              <tr v-if="hasFilter" class="text-left hidden lg:table-row">
                <th v-if="!!$slots['bulk-actions']"></th>
                <th
                  v-for="column in getColumns"
                  :key="column.field"
                  class="px-3 py-2 border-t"
                  :class="{
                    'text-right': column.numeric,
                    'text-center': column.centered,
                  }"
                >
                  <template v-if="column.searchable">
                    <component
                      :is="`${getFilterFromType(
                        column.filterType || column.type || 'text'
                      )}-filter`"
                      v-model="form.filter[column.field]"
                      v-bind="column.props"
                      class="max-w-40 h-8"
                      @input="onFilter"
                    />
                  </template>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              <data-table-row
                v-for="item in source.data"
                :key="item.id"
                :model-value="isItemSelected(item.id)"
                :can-select="!!$slots['bulk-actions']"
                class="hover:bg-gray-100 dark:hover:bg-gray-800"
                :class="{ 'cursor-pointer': rowClick }"
                :columns="getColumns"
                :item="item"
                @select="toggleSelectedItem(item.id)"
                @click="onRowClick(item.id)"
              >
                <template
                  v-for="column in getColumns"
                  :key="column.field"
                  #[`field:${column.field}`]="columnProps"
                >
                  <slot :name="`field:${column.field}`" v-bind="columnProps" />
                </template>
              </data-table-row>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <nav
          class="py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700"
          aria-label="Pagination"
        >
          <data-iterator
            :source="source"
            :hide-footer="hideFooter"
            :per-page-options="perPageOptions"
            class="w-full"
            @page-change="onPageChange"
          />
        </nav>
      </div>
      <span
        v-if="form.processing"
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
      >
        <spinner class="h-24 w-24 text-primary" />
      </span>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { computed, inject, PropType, provide, Ref, ref, watch } from 'vue'
  import { Model, PaginatedData } from '@admin/types'
  import { Column } from '@admin/types/data-table'
  import route from 'ziggy-js'
  import { useForm } from '@inertiajs/inertia-vue3'
  import { Inertia } from '@inertiajs/inertia'
  import { useDebounceFn } from '@vueuse/shared'

  const props = defineProps({
    source: {
      type: Object as PropType<PaginatedData<Model>>,
      required: true,
    },
    columns: {
      type: Array as PropType<(string | Column)[]>,
      required: true,
    },
    filter: Object as PropType<{ [key: string]: string }>,
    sort: String,
    rowClick: String,
    disableSearch: Boolean,
    hideHeader: Boolean,
    hideFooter: Boolean,
    perPageOptions: {
      type: Array as PropType<number[]>,
      default: () => [5, 10, 15, 32, 50, 100],
    },
  })

  const sortBy = ref('id')
  const sortDesc = ref(false)
  const selectAll = ref(false)
  const selected: Ref<string[] | number[]> = ref([])
  const resource = inject<string>('resource')

  const hasSelectedItems = computed(() => {
    return selected.value.length > 0
  })

  const isItemSelected = (id: string | number) => {
    return selected.value.includes(id as never)
  }

  const toggleSelectedItem = (id: string | number) => {
    if (isItemSelected(id)) {
      selectAll.value = false
      return selected.value.splice(selected.value.indexOf(id as never), 1)
    }
    return selected.value.push(id as never)
  }

  const onSelectAll = () => {
    if (selectAll.value) {
      selectAll.value = false
      selected.value = []
      return
    }
    selectAll.value = true
    // @ts-ignore
    selected.value = props.source.data.map((model) => model.id)
  }

  watch(
    () => props.sort,
    (val) => {
      if (!val) return

      if (val.startsWith('-')) {
        sortBy.value = val.substring(1)
        sortDesc.value = true
        return
      }
      sortBy.value = val
      sortDesc.value = false
    },
    { immediate: true }
  )

  const getColumns = computed((): Column[] =>
    props.columns.map((c) => (typeof c === 'string' ? { field: c } : c))
  )

  const getFilterFromType = (type: string) => {
    return (
      {
        email: 'text',
        switch: 'boolean',
      }[type] || type
    )
  }

  const getDefaultFilter = () => {
    return getColumns.value
      .filter((c) => c.searchable)
      .reduce(
        (acc, column) => {
          return { ...acc, [column.field]: '' }
        },
        props.disableSearch ? {} : ({ q: '' } as { [key: string]: string })
      )
  }

  const form = useForm({
    page: props.source.meta.current_page,
    perPage: props.source.meta.per_page,
    sort: props.sort,
    filter: {
      ...getDefaultFilter(),
      ...props.filter,
    },
  })

  provide('filter', form.filter)

  const doQuery = () => {
    selectAll.value = false

    form.get(location.pathname, {
      preserveState: true,
    })
  }

  const onPageChange = (pager: { page: number; perPage: number }) => {
    form.page = pager.page
    form.perPage = pager.perPage
    doQuery()
  }

  const onRowClick = (id: number | string) => {
    if (props.rowClick && resource) {
      Inertia.get(route(`admin.${resource}.${props.rowClick}`, { id }))
    }
  }

  const onSort = (column: Column) => {
    if (!column.sortable) return

    let prefix = ''

    if (column.field === sortBy.value && !sortDesc.value) {
      prefix = '-'
    }

    form.sort = `${prefix}${column.field}`
    doQuery()
  }

  const onFilter = useDebounceFn(() => {
    form.page = 1
    doQuery()
  })

  const hasFilter = computed(() => {
    return getColumns.value.filter((c) => c.searchable).length
  })
</script>
