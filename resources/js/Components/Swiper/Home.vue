<script lang="ts" setup>
import { useFetch } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  endpoint?: App.Route.Name
  route?: string
  type: 'book' | 'serie'
  title?: string
  url?: string
  square?: boolean
}>()

const items = ref<any>([])
const { laravel, http } = useFetch()

async function fetchItems() {
  let res: Response | undefined
  if (props.endpoint)
    res = await laravel.get(props.endpoint)
  else if (props.route)
    res = await http.get(props.route)
  else
    console.error('SwiperHome: No endpoint or url provided')

  if (res) {
    const body = await res.json()
    items.value = body.data
  }
  else {
    console.error('SwiperHome: No response')
  }
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
      :square="square"
      padding
    />
    <SwiperSeries
      v-else-if="type === 'serie'"
      :series="items"
      :title="title"
      :url="url"
      padding
    />
  </div>
</template>
