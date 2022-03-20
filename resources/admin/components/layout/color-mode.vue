<script setup lang="ts">
  import { useDark, useToggle } from '@vueuse/core'

  const isDark = useDark()
  const toggleDark = useToggle(isDark)

  // const toggleDark = () => {
  //   const root = document.documentElement.classList
  //   if (root.contains('dark')) {
  //     root.toggle('light')
  //     root.remove('dark')

  //     localStorage.setItem('color-scheme', 'light')
  //   } else {
  //     root.toggle('dark')
  //     root.remove('light')

  //     localStorage.setItem('color-scheme', 'dark')
  //   }
  // }
  const toggle = () => {
    toggleDark()
  }
</script>

<template>
  <button
    class="text-primary color-mode rounded-sm px-2 py-2 transition-colors duration-75 hover:bg-gray-100 focus:outline-transparent dark:hover:bg-gray-800"
    @click="toggle"
  >
    <span class="sun" title="Switch to dark mode">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
        />
      </svg>
    </span>
    <span class="moon" title="Switch to light mode">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
        />
      </svg>
    </span>
  </button>
</template>

<style lang="css" scoped>
  .icon {
    @apply rounded-md p-2 text-gray-500 transition-colors duration-75 hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700;
  }
  .moon {
    @apply hidden;
  }
  .dark .moon {
    @apply block;
  }
  .dark .sun {
    @apply hidden;
  }
</style>
