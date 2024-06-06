<script setup lang="ts">
import type { Query } from '@kiwilan/typescriptable-laravel'
import { usePagination } from '@/Composables/usePagination'

const props = defineProps<{
  query: Query
}>()

const { pages, previousPage, nextPage, nextPageLink } = usePagination(props.query)
</script>

<template>
  <div>
    <!-- <ILink
      v-if="query?.current_page !== query?.last_page"
      :href="nextPageLink"
      class="flex bg-gray-800 hover:bg-gray-700 h-14 w-full relative mt-10 rounded-md items-center justify-center space-x-2 animate-pulse"
    >
      <div>Next page</div>
      <SvgIcon
        name="arrow-right"
        class="h-5 w-5 text-gray-400"
      />
    </ILink> -->
    <div class="flex items-center justify-between border-t border-gray-700 py-3 mt-5">
      <div class="flex flex-1 justify-between md:hidden">
        <component
          :is="previousPage ? 'ILink' : 'span'"
          :href="previousPage"
          class="relative inline-flex items-center rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-100 hover:bg-gray-800"
        >
          Previous
        </component>
        <component
          :is="nextPage ? 'ILink' : 'a'"
          :href="nextPage"
          class="relative ml-3 inline-flex items-center rounded-md border border-gray-700 px-4 py-2 text-sm font-medium text-gray-100 hover:bg-gray-800"
        >
          Next
        </component>
      </div>
      <div class="hidden md:flex md:flex-1 md:items-center md:justify-between">
        <div>
          <p class="text-sm text-gray-100">
            Showing
            <span class="font-medium">{{ query.from }}</span>
            to
            <span class="font-medium">{{ query.to }}</span>
            of
            <span class="font-medium">{{ query.total }}</span>
            results
          </p>
        </div>
        <div>
          <nav
            class="isolate inline-flex -space-x-px rounded-md shadow-sm"
            aria-label="Pagination"
          >
            <component
              :is="previousPage ? 'ILink' : 'span'"
              :href="previousPage"
              :class="previousPage ? 'prev-next-active' : 'prev-next-not-active'"
              class="page rounded-l-md !px-2"
            >
              <span class="sr-only">Previous</span>
              <svg
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                  clip-rule="evenodd"
                />
              </svg>
            </component>
            <component
              :is="page.isLink ? 'ILink' : 'span'"
              v-for="page in pages"
              :key="page.label"
              :href="page.url"
              :class="page.class"
            >
              {{ page.label }}
            </component>
            <component
              :is="nextPage ? 'ILink' : 'a'"
              :href="nextPage"
              :class="nextPage ? 'prev-next-active' : 'prev-next-not-active'"
              class="page rounded-r-md !px-2"
            >
              <span class="sr-only">Next</span>
              <svg
                class="h-5 w-5"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                  clip-rule="evenodd"
                />
              </svg>
            </component>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="css" scoped>
.prev-next {
  @apply inline-flex items-center border border-transparent px-3 py-3 text-sm font-medium space-x-3 rounded-md;
}
.prev-next-active {
  @apply text-gray-300 hover:border-purple-200 hover:text-purple-200 hover:bg-purple-300 hover:bg-opacity-10;
}
.prev-next-not-active {
  @apply text-gray-500;
}

.page {
  /* @apply inline-flex items-center border rounded-md px-3.5 py-3 text-sm font-medium mx-1; */
  @apply relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-100 ring-1 ring-inset ring-gray-700 hover:bg-gray-800 focus:z-20 focus:outline-offset-0;
}
.page-active {
  /* @apply !border-purple-800  text-purple-300 bg-purple-300 bg-opacity-10; */
  @apply bg-purple-600 hover:bg-purple-600;
}
.page-not-active {
  /* @apply text-gray-300 hover:border-purple-200 hover:text-purple-200 border-transparent hover:bg-purple-800 hover:bg-opacity-10; */
  @apply hover:!bg-purple-600/80;
}
.page-disabled {
  /* @apply text-gray-400 border-transparent; */
  @apply hover:!bg-transparent;
}
</style>
