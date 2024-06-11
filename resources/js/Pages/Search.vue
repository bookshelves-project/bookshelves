<script lang="ts" setup>
import type { Entity } from '@/Types'

defineProps<{
  data: Entity[]
  query?: string
  count?: number
}>()
</script>

<template>
  <App :title="`Search for '${query}' (${count} results)`">
    <section class="main-container py-10 books-grid">
      <CardEntity
        v-for="item in data"
        :key="item.slug"
        :entity="item"
      />
    </section>
  </App>
</template>
