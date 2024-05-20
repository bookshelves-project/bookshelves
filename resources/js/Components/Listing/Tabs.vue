<script lang="ts" setup>
import { router } from '@inertiajs/vue3'

defineProps<{
  links: { label: string, href: string }[]
}>()

const libraryTab = ref<string>()

const currentUrl = computed(() => {
  let url = window.location.href
  const domain = window.location.origin

  if (url.includes('?'))
    url = url.split('?')[0]

  if (url.includes(domain))
    url = url.replace(domain, '')

  return url
})

function push(event: Event) {
  const url = (event.target as any).value
  router.get(url)
}

onMounted(() => {
  libraryTab.value = currentUrl.value
})
</script>

<template>
  <div>
    <div class="md:hidden px-3">
      <label
        for="tabs"
        class="sr-only"
      >Select a tab</label>
      <select
        id="tabs"
        v-model="libraryTab"
        name="tabs"
        class="block w-full rounded-md border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 bg-gray-800"
        @change="push($event)"
      >
        <option
          v-for="link in links"
          :key="link.href"
          :value="link.href"
        >
          {{ link.label }}
        </option>
      </select>
    </div>
    <div class="hidden md:block">
      <nav
        class="isolate flex divide-x divide-gray-800"
        aria-label="Tabs"
      >
        <ILink
          v-for="link in links"
          :key="link.href"
          :href="link.href"
          class="group relative min-w-0 flex-1 overflow-hidden bg-gray-900 py-4 px-4 text-center text-sm font-medium hover:bg-gray-800 focus:z-10"
          :class="link.href === currentUrl ? 'text-gray-100' : 'text-gray-400'"
          aria-current="page"
        >
          <span>
            {{ link.label }}
          </span>
          <span
            v-if="link.href === currentUrl"
            aria-hidden="true"
            class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"
          />
        </ILink>
      </nav>
    </div>
  </div>
</template>
