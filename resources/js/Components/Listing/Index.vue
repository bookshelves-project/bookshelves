<script lang="ts" setup>
import { usePagination, useQuery } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  query: App.Paginate<any>
  sortable?: { label: string, value: string }[]
}>()

// const { sortBy, sortReverse, isReversed, limitTo, request, total } = useQuery<App.Models.Book>(props.query)
// const { nextPageLink } = usePagination(props.query)
// const pagination = [10, 25, 50, 100]
</script>

<template>
  <section class="main-container py-6">
    <slot name="breadcrumbs" />
    <div class="flex items-center justify-between">
      <ul
        class="books-grid mt-6"
        role="list"
      >
        <slot />
      </ul>
    </div>
  </section>
</template>

<style lang="css" scoped>
.action-btn {
  @apply flex items-center space-x-2 rounded-md px-2 py-1 hover:bg-gray-700;
}
.sort-btn {
  @apply w-full rounded-md px-2 py-1 text-left hover:bg-gray-600;
}
</style>
