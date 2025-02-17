<script lang="ts" setup>
defineProps<{
  subtitle?: string
  title: string
  text: string
}>()
</script>

<template>
  <div class="pt-6 sm:pt-8 pb-6 sm:pb-8">
    <div class="mx-auto px-6">
      <div class="mx-auto max-w-4xl lg:mx-0">
        <p
          v-if="subtitle"
          class="text-base/7 font-semibold text-indigo-300"
        >
          {{ subtitle }}
        </p>
        <h2 class="mt-2 text-3xl font-semibold tracking-tight text-gray-100 sm:text-5xl">
          {{ title }}
        </h2>
        <p class="mt-8 text-pretty text-lg font-medium text-gray-300 sm:text-xl/8">
          {{ text }}
        </p>
      </div>
    </div>
  </div>
</template>
