<script lang="ts" setup>
import { useSidebar } from '@kiwilan/typescriptable-laravel'

const { open } = useSidebar()
</script>

<template>
  <div
    class="sticky top-0 z-40 flex h-16 shrink-0 items-center border-b border-white/5 bg-gray-900 shadow-sm"
  >
    <button
      class="relative ml-6 rounded-md p-2.5 text-white hover:bg-gray-700 xl:hidden"
      type="button"
      x-data
      @click="open()"
    >
      <span class="sr-only">Open sidebar</span>
      <svg
        class="h-5 w-5"
        aria-hidden="true"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z"
          clip-rule="evenodd"
        />
      </svg>
    </button>

    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
      <SearchBar />
    </div>

    <LayoutProfile />
  </div>
</template>
