<script lang="ts" setup>
import type { HttpResponse } from '@kiwilan/typescriptable-laravel'
import { useFetch } from '@kiwilan/typescriptable-laravel'
import { useInstance } from '@/Composables/useInstance'

const props = defineProps<{
  endpoint?: App.Route.Name
  route?: string
  type: 'book' | 'serie'
  title?: string
  url?: string
  square?: boolean
}>()

const items = ref<App.Models.Book[] | App.Models.Serie[]>()
items.value = []
const { laravel, http } = useFetch()

async function fetchItems() {
  let res: HttpResponse | undefined
  if (props.endpoint)
    res = await laravel.get(props.endpoint)
  else if (props.route)
    res = await http.get(props.route)
  else
    console.error('SwiperHome: No endpoint or url provided')

  if (res) {
    const body = await res.getBody<{ data: App.Models.Book[] | App.Models.Serie[] }>()
    items.value = body?.data
  }
  else {
    console.error('SwiperHome: No response')
  }
}

const { toBooks, toSeries } = useInstance()

onMounted(() => {
  fetchItems()
})
</script>

<template>
  <div v-if="items?.length">
    <SwiperBooks
      v-if="type === 'book'"
      :books="toBooks(items)"
      :title="title"
      :url="url"
      :square="square"
      padding
    />
    <SwiperSeries
      v-else-if="type === 'serie'"
      :series="toSeries(items)"
      :title="title"
      :url="url"
      padding
    />
  </div>
</template>
