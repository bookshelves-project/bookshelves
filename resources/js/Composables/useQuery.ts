import { useForm, usePage } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'

type UrlQuery = Record<string, string | number | boolean | string[] | number[] | boolean[]>

interface Filter { field: string, value: string, replaceAll?: boolean }

export interface Query<T = any> extends App.Paginate<T> {
  sort?: string
  filter?: string | number | boolean | string[] | number[] | boolean[]
}

export interface SortItem {
  label: string
  value: string
}

export function useQuery<T>(propQuery: App.Paginate<T>, prop: string = 'query') {
  const current = ref<Query<T>>()
  const total = ref<number>()
  const isCleared = ref<boolean>(false)
  const sort = ref<string>()
  // const filter = ref<string>()
  const filters = ref<Filter[]>()
  // const filterMultiple = ref<string[]>()
  const limit = ref<number>(10)
  const isReversed = ref(false)

  current.value = propQuery
  total.value = propQuery.total
  sort.value = current.value.sort
  limit.value = current.value.per_page

  function initializeBy(queryName: string, variable: Ref<string | undefined>) {
    const { url } = usePage()
    let search: string | undefined
    if (url.includes('?'))
      search = `?${url.split('?')[1]}`

    const query = new URLSearchParams(search)
    const queryType = query.get(queryName)
    if (queryType)
      sort.value = queryType
    if (variable.value && variable.value.startsWith('-'))
      isReversed.value = true
    setLimit()
  }

  /**
   * Set the sort value to the query.
   */
  function initializeSort() {
    initializeBy('sort', sort)
  }

  function setLimit() {
    const localLimit = localStorage.getItem('limit') ?? limit.value.toString()
    limit.value = Number.parseInt(localLimit)

    merge({
      limit: limit.value.toString(),
    })
  }

  /**
   * Limit the number of results.
   */
  function limitTo(l: number) {
    limit.value = l
    localStorage.setItem('limit', limit.value.toString())

    merge({
      limit: l.toString(),
    })
  }

  /**
   * Execute the query.
   */
  function execute(q: UrlQuery) {
    const form = useForm({
      ...q,
    })
    form.get(location.pathname, {
      preserveState: true,
      onSuccess: (page) => {
        // if `defineProps` use different name for query, we need to get it from `page.props`
        const d = page.props[prop] as T
        current.value = undefined
        setTimeout(() => {
          current.value = d as any
        }, 250)
      },
    })
  }

  /**
   * Clear the filter value from the query.
   */
  const clear = () => {
    isCleared.value = true
    const c = new URLSearchParams(location.search)

    if (c.has('limit')) {
      execute({
        limit: c.get('limit') as string,
      })
    }
    else {
      execute({})
    }
  }

  /**
   * Compare deep equality of two objects.
   */
  function deepEqual(x: object, y: object): boolean {
    const ok = Object.keys
    const tx = typeof x
    const ty = typeof y
    return (x && y && tx === 'object' && tx === ty)
      ? (
          ok(x).length === ok(y).length
          // @ts-expect-error deepEqual type error 'No index signature'
          && ok(x).every(key => deepEqual(x[key], y[key]))
        )
      : (x === y)
  }

  /**
   * Merge the given query into the current query string.
   */
  function merge(queryToAdd: UrlQuery, isFilter: boolean = false): UrlQuery {
    const c = new URLSearchParams(location.search)

    const current: UrlQuery = {}
    c.forEach((value, key) => {
      current[key] = value
    })

    const mergedQuery: UrlQuery = {
      ...queryToAdd,
    }

    for (const currentKey in current) {
      if (isFilter) {
        delete mergedQuery.filter
        mergedQuery.filter = {} as any
        filters.value?.forEach((filter) => {
          (mergedQuery.filter as any)[filter.field] = filter.value
        })

        mergedQuery[currentKey] = queryToAdd[currentKey] || current[currentKey]
      }
      else {
        // If it's an array, we need to merge the values
        if (queryToAdd[currentKey] && currentKey.includes('[')) {
          // const existing = current[currentKey].split(',')
          // const values = [queryToAdd[currentKey], ...existing]
          // const cleaned = [...new Set(values)].sort()
          // mergedQuery[currentKey] = cleaned.join(',')
        }
        // If it's not an array, we just need to override the value
        else {
          mergedQuery[currentKey] = queryToAdd[currentKey] || current[currentKey]
        }
      }
    }

    if (!deepEqual(mergedQuery, current))
      execute(mergedQuery)

    return mergedQuery
  }

  /**
   * Sort by the given field.
   *
   * Example: `?sort=-title`
   */
  function sortBy(field: string) {
    if (field === sort.value) {
      sortReverse()
      return
    }

    sort.value = field
    merge({
      sort: sort.value,
    })
  }

  /**
   * Reverse the current sort direction.
   */
  function sortReverse() {
    if (sort.value) {
      const isReverse = sort.value?.startsWith('-')
      const s = sort.value?.replace('-', '')
      sort.value = isReverse ? s : `-${s}`

      merge({
        sort: sort.value,
      })

      isReversed.value = !isReversed.value
    }
  }

  /**
   * Filter by the given field.
   *
   * Example: `?filter[title]=vague&filter[language]=french,english`
   */
  function filterBy(field: string, value: string) {
    // if (field === sort.value) {
    //   sortReverse()
    //   return
    // }

    if (!filters.value) {
      filters.value = []
    }

    filters.value.push({ field, value })
    merge({}, true)
  }

  onMounted(() => {
    initializeSort()
  })

  return {
    query: current,
    total,
    clear,
    sortBy,
    sortReverse,
    filterBy,
    isReversed,
    limitTo,
  }
}
