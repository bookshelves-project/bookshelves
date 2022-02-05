<template>
  <div
    class="fixed right-0 top-0 z-50 h-full bg-white overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 shadow-xl"
  >
    <div class="h-full bg-white p-8">
      <div class="pb-16 space-y-6">
        <header class="flex items-center mb-8">
          <h2 class="font-semibold text-gray-800 leading-tight w-3/4">
            {{ title }}
          </h2>

          <inertia-link
            :href="route(`admin.${resource}`)"
            class="inline-block p-2 text-white rounded-full bg-primary-500 ml-auto"
            :only="['action']"
          >
            <x-icon class="h-5 w-5" />
          </inertia-link>
        </header>
        <slot />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { inject } from 'vue'

  defineProps({
    title: String,
  })

  const resource = inject<string>('resource')
</script>
