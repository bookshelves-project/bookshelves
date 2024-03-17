<script lang="ts" setup>
import { useFetch } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  endpoint: App.Route.Name
  type: 'book' | 'serie'
  title?: string
  url?: string
}>()

const items = ref<any>([])
const { laravel } = useFetch()

async function fetchItems() {
  const res = await laravel.get(props.endpoint)
  const body = await res.json()
  items.value = body.data
}
fetchItems()
</script>

<template>
  <div v-if="items.length">
    <SwiperBooks
      v-if="type === 'book'"
      :books="items"
      :title="title"
      :url="url"
      padding
    />
    <SwiperSeries
      v-else-if="type === 'serie'"
      :series="items"
      :title="title"
      padding
    />
  </div>
</template>
