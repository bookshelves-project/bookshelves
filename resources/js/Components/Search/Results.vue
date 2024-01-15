<script lang="ts" setup>
import { useDate, useRouter } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  results: any[]
  search?: string
  fullResults?: boolean
}>()

const { route } = useRouter()
const { formatDate } = useDate()

function name(item: any) {
  return item.title ?? item.name
}

function year(item: any) {
  const year = item.year ?? item.first_air_date?.slice(0, 4)
  if (year)
    return `(${year})`
}

function extra(item: any) {
  let extra = ''

  if (item.edition)
    extra += item.edition

  if (item.seasons_count) {
    if (extra)
      extra += ' · '

    extra += `${item.seasons_count} seasons`
  }

  return extra
}

const seeResults = computed(() => {
  const url = route('search.index')

  return `${url}?${new URLSearchParams({
    search: props.search ?? '',
  }).toString()}`
})
</script>

<template>
  <ul class="space-y-1">
    <li v-if="results.length === 0">
      No results
    </li>
    <li
      v-for="result in results"
      :key="result.id"
    >
      <ILink
        class="block md:flex items-center rounded-md px-2 py-1 text-base hover:bg-slate-700 justify-between"
        :href="result.show_route"
      >
        <div class="flex items-center justify-between w-full">
          <div class="flex items-center">
            <AppImg
              class="mr-2 aspect-poster h-14 w-auto rounded-md object-cover"
              :src="result.poster_url"
              :color="result.poster_color"
            />
            <div>
              <div>
                {{ name(result) }} {{ year(result) }}
              </div>
              <div class="text-sm text-gray-400 flex items-center space-x-1">
                <div>
                  {{ result.type }}
                </div>
                <div v-if="extra(result)">
                  ·
                </div>
                <div>
                  {{ extra(result) }}
                </div>
              </div>
            </div>
          </div>
          <div class="text-sm text-gray-400">
            Added at {{ formatDate(result.added_at) }}
          </div>
        </div>
      </ILink>
    </li>
    <li v-if="fullResults && results.length > 0">
      <ILink
        :href="seeResults"
        class="py-3 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-md"
      >
        See more results
      </ILink>
    </li>
  </ul>
</template>
