<script lang="ts" setup>
// import { useQuery } from '@kiwilan/typescriptable-laravel'
import { useFetch } from '@kiwilan/typescriptable-laravel'
import { useQuery } from '@/Composables/useQuery'

type Entity = App.Models.Book | App.Models.Author | App.Models.Serie | App.Models.Tag
const props = defineProps<{
  query: App.Paginate<Entity>
  sortable?: { label: string, value: string }[]
  filterable?: { label: string, value: string }[]
}>()
const languages = ref<App.Models.Language[]>()

const {
  sortBy,
  sortReverse,
  isReversed,
  filterBy,
  clear,
  limitTo,
  query: listQuery,
  total,
} = useQuery<Entity>(props.query)
const { laravel } = useFetch()
const pagination = [10, 25, 50, 100]

onMounted(async () => {
  const res = await laravel.get('api.languages.index')
  languages.value = await res.getBody<App.Models.Language[]>()
})
</script>

<template>
  <section class="main-container py-6">
    <slot name="breadcrumbs" />
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-1">
        <JetstreamDropdown align="left">
          <template #trigger>
            <button class="action-btn">
              <span>Per page</span>
              <SvgIcon
                name="chevron-down"
                class="h-4 w-4"
              />
            </button>
          </template>
          <template #content>
            <div class="p-1">
              <button
                v-for="item in pagination"
                :key="item"
                class="sort-btn"
                @click="limitTo(item)"
              >
                {{ item }}
              </button>
            </div>
          </template>
        </JetstreamDropdown>
        <JetstreamDropdown align="left">
          <template #trigger>
            <button class="action-btn">
              <span>Sort by</span>
              <SvgIcon
                name="chevron-down"
                class="h-4 w-4"
              />
            </button>
          </template>
          <template #content>
            <div class="p-1">
              <button
                v-for="item in sortable"
                :key="item.value"
                class="sort-btn"
                @click="sortBy(item.value)"
              >
                {{ item.label }}
              </button>
            </div>
          </template>
        </JetstreamDropdown>
        <button
          class="flex self-stretch rounded-md px-2 py-1 hover:bg-gray-700"
          @click="sortReverse"
        >
          <SvgIcon
            name="arrow-down"
            :class="{
              'rotate-180': isReversed,
            }"
            class="inline-block h-4 w-4 transition-transform duration-200 m-auto"
          />
        </button>
      </div>
      <div class="flex items-center space-x-2">
        <JetstreamDropdown
          v-if="languages"
          align="left"
        >
          <template #trigger>
            <button class="action-btn">
              <span>Language</span>
              <SvgIcon
                name="chevron-down"
                class="h-4 w-4"
              />
            </button>
          </template>
          <template #content>
            <div class="py-2 px-3">
              <fieldset>
                <legend class="sr-only">
                  Languages
                </legend>
                <div class="space-y-2">
                  <div
                    v-for="language in languages"
                    :key="language.slug"
                    class="relative flex items-start"
                  >
                    <button
                      class="hover:bg-gray-700 rounded-md w-full px-2 py-1 text-left"
                      @click="filterBy('language', language.slug)"
                    >
                      <span class="text-gray-100">{{ language.name }}</span>
                    </button>
                    <!-- <div class="flex h-6 items-center">
                      <input
                        :id="language.slug"
                        :aria-describedby="`${language.slug}-description`"
                        :name="language.slug"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-indigo-600 focus:ring-indigo-600 focus:ring-offset-gray-800"
                        @click="filterBy('language', language.slug)"
                      >
                    </div>
                    <div class="ml-3 text-sm leading-6">
                      <label
                        :for="language.slug"
                        class="font-medium text-gray-100"
                      >{{ language.name }}</label>
                    </div> -->
                  </div>
                </div>
              </fieldset>
            </div>
          </template>
        </JetstreamDropdown>
        <button
          class="p-1.5 hover:bg-gray-700 rounded-md"
          @click="clear()"
        >
          <SvgIcon
            name="close"
            class="w-5 h-5"
          />
        </button>
        <div class="text-gray-400">
          <span v-if="total">{{ total }} elements</span>
          <span v-else>No elements</span>
        </div>
      </div>
    </div>
    <ul
      class="books-grid mt-6"
      role="list"
    >
      <slot />
    </ul>
    <div
      v-if="listQuery?.total === 0"
      class="relative flex w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center"
    >
      <div class="mx-auto flex-col">
        <SvgIcon
          name="ereader"
          class="h-12 w-12 text-gray-400 mx-auto block"
        />
        <span class="mt-2 block text-sm font-semibold text-gray-100 mx-auto">No elements</span>
      </div>
    </div>
    <div
      v-if="listQuery && listQuery.last_page > 1"
      class="mt-12"
    >
      <ListingPagination :query="listQuery" />
    </div>
  </section>
</template>

<style lang="css" scoped>
.action-btn {
  @apply flex items-center space-x-2 rounded-md px-2 py-1 hover:bg-gray-700;
}
.sort-btn {
  @apply w-full rounded-md px-2 py-1 text-left hover:bg-gray-600;
}
</style>
