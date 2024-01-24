<script lang="ts" setup>
import { usePaginate, useQuery } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  query: App.Paginate<any>
  sortable?: { label: string, value: string }[]
}>()

const { sortBy, sortReverse, isReversed, limitTo, request } = useQuery<App.Models.Book>(props.query)
const { nextPage } = usePaginate(props.query)
const pagination = [10, 25, 50, 100]
</script>

<template>
  <section class="main-container py-6">
    <slot name="breadcrumbs" />
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-1">
        <JetstreamDropdown align="left">
          <template #trigger>
            <button class="action-btn">
              <span>Per page</span>
              <SvgIcon
                name="chevron-down"
                class="h-4 w-4"
              />
            </button>
          </template>
          <template #content>
            <div class="p-1">
              <button
                v-for="item in pagination"
                :key="item"
                class="sort-btn"
                @click="limitTo(item)"
              >
                {{ item }}
              </button>
            </div>
          </template>
        </JetstreamDropdown>
        <JetstreamDropdown align="left">
          <template #trigger>
            <button class="action-btn">
              <span>Sort by</span>
              <SvgIcon
                name="chevron-down"
                class="h-4 w-4"
              />
            </button>
          </template>
          <template #content>
            <div class="p-1">
              <button
                v-for="item in sortable"
                :key="item.value"
                class="sort-btn"
                @click="sortBy(item.value)"
              >
                {{ item.label }}
              </button>
            </div>
          </template>
        </JetstreamDropdown>
        <button
          class="flex self-stretch rounded-md px-2 py-1 hover:bg-gray-700"
          @click="sortReverse"
        >
          <SvgIcon
            name="arrow-down"
            :class="{
              'rotate-180': isReversed,
            }"
            class="inline-block h-4 w-4 transition-transform duration-200 m-auto"
          />
        </button>
      </div>
      <div
        v-if="request?.total"
        class="text-gray-400"
      >
        {{ request.total }} elements
      </div>
      <div
        v-else
        class="text-gray-400"
      >
        No elements
      </div>
    </div>
    <div class="video-list mt-6">
      <slot />
      <ILink
        v-if="nextPage"
        :href="nextPage"
        class="poster flex bg-gray-800 hover:bg-gray-700 h-full w-full relative"
      >
        <SvgIcon
          name="arrow-right"
          class="h-12 w-12 text-gray-400 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
        />
      </ILink>
    </div>
    <div
      v-if="request?.total === 0"
      class="relative flex w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center"
    >
      <div class="mx-auto flex-col">
        <SvgIcon
          name="ereader"
          class="h-12 w-12 text-gray-400 mx-auto block"
        />
        <span class="mt-2 block text-sm font-semibold text-gray-100 mx-auto">No elements</span>
      </div>
    </div>
    <div
      v-if="request && request.last_page > 1"
      class="mt-12"
    >
      <ListingPagination :query="request" />
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
