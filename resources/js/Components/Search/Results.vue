<script lang="ts" setup>
import { useDate, useRouter } from '@kiwilan/typescriptable-laravel'
import { useUtils } from '@/Composables/useUtils'
import type { SearchEntity } from '@/Types'

const props = defineProps<{
  response: SearchEntity
  fullResults?: boolean
}>()

const { route } = useRouter()

const seeResults = computed(() => {
  const url = route('search.index')

  return `${url}?${new URLSearchParams({
    search: props.response.query ?? '',
  }).toString()}`
})
</script>

<template>
  <ul class="space-y-1">
    <li v-if="response.data.length === 0">
      No results
    </li>
    <li
      v-for="item in response.data"
      :key="item.slug"
    >
      <ILink
        class="block md:flex items-center rounded-md px-2 py-1 text-base hover:bg-slate-700 justify-between"
        :href="item.route"
      >
        <div class="flex items-center justify-between w-full">
          <div class="flex items-center">
            <AppImg
              class="mr-2 aspect-poster h-14 w-auto rounded-md object-cover"
              :src="item.cover_thumbnail"
              :color="item.cover_color"
            />
            <div>
              <div class="flex items-center space-x-1">
                <span>
                  {{ item.title }}
                </span>
                <span class="text-gray-400 italic lowercase">
                  ({{ item.class }})
                </span>
              </div>
              <div class="text-sm text-gray-400 flex items-center space-x-2">
                <span v-if="item.library">
                  {{ item.library.name }}
                </span>
                <span v-if="item.serie">/</span>
                <span v-if="item.serie">
                  {{ item.serie.title }} #{{ item.volume }}
                </span>
                <span v-if="item.language">/</span>
                <span v-if="item.language">
                  {{ item.language.name }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </ILink>
    </li>
    <li v-if="fullResults && response.count > 0">
      <ILink
        :href="seeResults"
        class="py-3 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-md"
      >
        See more results
      </ILink>
    </li>
  </ul>
</template>
