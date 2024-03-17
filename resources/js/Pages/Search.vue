<script lang="ts" setup>
import { useSearch } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  results: object
  search?: string
}>()

const { convertResults } = useSearch(false)
const items = ref<any[]>([])

items.value = convertResults(props.results)
</script>

<template>
  <App :title="`Search for '${search}'`">
    <section class="main-container py-10 books-list">
      <CardEntity
        v-for="item in items"
        :key="item.id"
        :entity="item"
      />
    </section>
  </App>
</template>
