<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const version = computed(() => page.props.appVersion)
</script>

<template>
  <footer class="mt-8 mb-6 md:mt-0 md:mb-0">
    <div class="md:flex md:items-center md:justify-between w-full px-6">
      <div class="flex justify-center space-x-6 md:order-2" />
      <div class="mt-4 md:order-1 md:mt-0">
        <p class="text-xs leading-5 text-gray-400 flex items-center space-x-1 justify-center">
          <span>Powered by <a
            href="https://github.com/bookshelves-project/bookshelves"
            target="_blank"
            rel="noopener noreferrer"
            class="link"
          >Bookshelves</a> v{{ version }}</span>
        </p>
      </div>
    </div>
  </footer>
</template>
