<script lang="ts" setup>
import { onClickOutside } from '@vueuse/core'
import { useSearch } from '@kiwilan/typescriptable-laravel'

const {
  keybinding,
  loading,
  searchText,
  searchField,
  searching,
  closeSearch,
  searchUsed,
  clearSearch,
  results,
} = useSearch()

const target = ref<HTMLElement>()
onClickOutside(target, () => closeSearch())

onMounted(() => {
  keybinding()
})
</script>

<template>
  <div
    ref="target"
    class="relative flex flex-1 pl-4 hover:bg-gray-800"
  >
    <label
      class="sr-only"
      for="search-field"
    >Search</label>
    <form class="relative w-full">
      <div class="pointer-events-none absolute inset-y-0 left-0 flex">
        <div
          v-if="loading"
          class="m-auto"
        >
          <AppLoading />
        </div>
        <svg
          v-else
          class="h-full w-5 text-gray-500"
          aria-hidden="true"
          x-show="!loading"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
            clip-rule="evenodd"
          />
        </svg>
        <span
          v-if="!searchUsed"
          class="absolute hidden md:block md:left-96 top-1/2 -translate-y-1/2 transform rounded-md border border-gray-700 px-2 py-1 text-xs text-gray-400"
          v-html="searchText"
        />
      </div>
      <input
        id="search-field"
        ref="searchField"
        class="block h-full w-full border-0 bg-transparent py-0 pl-8 pr-0 text-white focus:ring-0 sm:text-sm"
        name="search"
        type="search"
        autocomplete="off"
        placeholder="Search book, book series, author..."
        @input="event => searching(event)"
      >
      <button
        v-if="searchUsed"
        class="absolute inset-y-0 right-0 h-full w-5 text-gray-500"
        @click="clearSearch"
      >
        <SvgIcon
          name="x-mark"
          class="relative z-10 h-5 w-5"
        />
      </button>
    </form>
    <div
      v-if="results.length > 0"
      class="absolute top-14 max-h-[90vh] w-full overflow-auto rounded-md border border-gray-600 bg-gray-800 px-2 py-1.5 shadow md:max-h-96"
    >
      <SearchResults
        :results="results"
        :search="searchField?.value"
        :full-results="true"
      />
    </div>
  </div>
</template>
