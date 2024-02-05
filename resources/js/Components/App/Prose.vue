<script lang="ts" setup>
defineProps<{
  subtitle: string
  title: string
  description: string
  contents: string
}>()
</script>

<template>
  <div class="px-6 lg:px-8">
    <div class="mx-auto max-w-3xl text-base leading-7 text-gray-300">
      <p class="text-base font-semibold leading-7 text-indigo-400">
        {{ subtitle }}
      </p>
      <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-100 sm:text-4xl">
        {{ title }}
      </h1>
      <p class="mt-6 text-xl leading-8">
        {{ description }}
      </p>
      <div class="mt-10 max-w-2xl">
        <div class="prose dark:prose-invert">
          <div v-html="contents" />
        </div>
      </div>
    </div>
  </div>
</template>
