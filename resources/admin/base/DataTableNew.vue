<template>
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Users</h1>
        <p class="mt-2 text-sm text-gray-700">
          A list of all the users in your account including their name, title,
          email and role.
        </p>
      </div>
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <button
          type="button"
          class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
        >
          Add user
        </button>
      </div>
    </div>
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div
            class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
          >
            <!-- Selected row actions, only show when rows are selected. -->
            <!-- <div
              class="absolute top-0 left-12 flex h-12 items-center space-x-3 bg-gray-50 sm:left-16"
            >
              <button
                type="button"
                class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
              >
                Bulk edit
              </button>
              <button
                type="button"
                class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
              >
                Delete all
              </button>
            </div> -->

            <table class="min-w-full table-fixed divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                    <input
                      type="checkbox"
                      class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
                    />
                  </th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    <a href="#" class="group inline-flex">
                      Title
                      <!-- Active: "bg-gray-200 text-gray-900 group-hover:bg-gray-300", Not Active: "invisible text-gray-400 group-hover:visible group-focus:visible" -->
                      <span
                        class="ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300"
                      >
                        <!-- Heroicon name: solid/chevron-down -->
                        <svg
                          class="h-5 w-5"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          aria-hidden="true"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </span>
                    </a>
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                  >
                    Email
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                  >
                    Email
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <!-- Selected: "bg-gray-50" -->
                <tr>
                  <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                    <!-- Selected row marker, only show when row is selected. -->
                    <div
                      class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"
                    ></div>

                    <input
                      type="checkbox"
                      class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
                    />
                  </td>
                  <td
                    class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                  >
                    <a href="#" class="text-indigo-600 hover:text-indigo-900"
                      >Edit<span class="sr-only">, Lindsay Walton</span></a
                    >
                  </td>
                  <!-- Selected: "text-indigo-600", Not Selected: "text-gray-900" -->
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-3">
                    <div class="flex items-center">
                      <div class="h-10 w-10 flex-shrink-0">
                        <img
                          class="h-10 w-10 rounded-full"
                          src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                          alt=""
                        />
                      </div>
                      <div class="ml-4">
                        <div class="font-medium text-gray-900">
                          Lindsay Walton
                        </div>
                        <div class="text-gray-500">
                          lindsay.walton@example.com
                        </div>
                      </div>
                    </div>
                  </td>
                  <td
                    class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell"
                  >
                    Front-end Developer
                  </td>
                  <td
                    class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell"
                  >
                    lindsay.walton@example.com
                  </td>
                </tr>

                <!-- More people... -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
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
