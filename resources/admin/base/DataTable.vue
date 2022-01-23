<template>
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
          class="
            h-5
            w-5
            absolute
            top-1/2
            right-4
            transform
            -translate-y-1/2
            opacity-50
          "
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
  <div
    class="
      bg-white
      rounded-md
      shadow
      overflow-x-auto
      relative
      scrollbar-thin scrollbar-thumb-primary-900 scrollbar-track-gray-100
    "
  >
    <table
      class="w-full whitespace-nowrap"
      :class="{ 'opacity-25': form.processing }"
    >
      <thead>
        <tr class="text-left">
          <th
            v-if="!!$slots['bulk-actions']"
            class="px-4 pt-6 pb-4 border-b text-center"
          >
            <input
              :checked="selectAll"
              type="checkbox"
              class="w-6 h-6"
              @change="onSelectAll"
            />
          </th>
          <th
            v-for="column in getColumns"
            :key="column.field"
            class="px-6 pt-6 pb-4 border-primary-500"
            :style="column.width ? `width: ${column.width}px` : ''"
            :class="{
              'text-right': column.numeric,
              'text-center': column.centered,
              'border-b': column.field === sortBy,
              'hover:border-b cursor-pointer': column.sortable,
            }"
            @click="onSort(column)"
          >
            <div
              v-if="column.sortable"
              type="button"
              class="inline-flex items-center font-bold"
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
            <span v-else>
              {{ column.label || $ta(column.field) }}
            </span>
          </th>
        </tr>
        <tr v-if="hasFilter" class="text-left">
          <th v-if="!!$slots['bulk-actions']"></th>
          <th
            v-for="column in getColumns"
            :key="column.field"
            class="px-6 py-2 border-t"
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
                class="max-w-48"
                @input="onFilter"
              />
            </template>
          </th>
        </tr>
      </thead>
      <tbody>
        <data-table-row
          v-for="item in source.data"
          :key="item.id"
          :model-value="isItemSelected(item.id)"
          :can-select="!!$slots['bulk-actions']"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
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
        <tr v-if="source.data.length === 0">
          <td
            class="border-t px-6 py-4 text-center"
            :colspan="
              !!$slots['bulk-actions']
                ? getColumns.length + 1
                : getColumns.length
            "
          >
            {{ $t('admin.data-table.empty') }}
          </td>
        </tr>
      </tbody>
    </table>
    <span
      v-if="form.processing"
      class="
        absolute
        top-1/2
        left-1/2
        transform
        -translate-x-1/2 -translate-y-1/2
      "
    >
      <spinner class="h-24 w-24 text-primary" />
    </span>
  </div>

  <data-iterator
    :source="source"
    :hide-footer="hideFooter"
    :per-page-options="perPageOptions"
    @page-change="onPageChange"
  />
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
      default: () => [5, 10, 15, 30, 50, 100],
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

  const onRowClick = (id: number) => {
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
