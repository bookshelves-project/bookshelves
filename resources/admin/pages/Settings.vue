<template>
  <app-layout :title="title">
    <!-- <dashboard-content /> -->
    <ul>
      <li v-for="(item, index) in configuration" :key="index" class="my-2">
        <code>{{ index }}</code
        >:
        <span
          v-if="item"
          class="py-0.5 px-1 rounded-md bg-gray-500 text-white shadow-sm"
          >{{ item }}</span
        >
      </li>
    </ul>
  </app-layout>
</template>

<script setup lang="ts">
  import { useTitle } from '@admin/features/helpers'

  const title = useTitle('Settings')

  const props = defineProps<{
    configuration: any[]
  }>()
</script>
