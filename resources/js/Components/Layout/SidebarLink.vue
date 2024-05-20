<script lang="ts" setup>
import { useInertia, useRouter } from '@kiwilan/typescriptable-laravel'
import type { Link } from '@/Composables/useNavigation'

export interface Props {
  link: Link
  hover?: string
  active?: string
}

const props = withDefaults(defineProps<Props>(), {
  hover: 'dark:hover:bg-gray-800',
  active: 'dark:bg-gray-800 dark:text-white',
})

const { route, currentRoute } = useRouter()
const { page, url } = useInertia()

const user = ref<App.Models.User>(page.props.auth?.user)

const href = computed(() => {
  const link = props.link
  if (!link.route)
    link.isExternal = true

  if (link.route)
    return route(link.route.name, link.route.params)

  return link.url
})

const isActive = computed(() => {
  if (!props.link.isLibrary)
    return href.value === currentRoute.value?.path

  const currentUrl = url.value.split('?')[0]

  return props.link.libraryUrl === currentUrl || props.link.librarySeriesUrl === currentUrl
})
</script>

<template>
  <li>
    <div
      v-if="link.isSeperator"
      class="py-2"
    >
      <hr class="border-gray-200 dark:border-gray-700">
    </div>
    <template v-else>
      <component
        :is="link.isExternal ? 'a' : 'ILink'"
        v-if="!link.restrictedRoles || link.restrictedRoles.includes(user.role ?? '')"
        :href="href"
        :target="link.isExternal ? '_blank' : null"
        :rel="link.isExternal ? 'noopener noreferrer' : null"
        :class="[
          isActive ? active : '',
          hover,
        ]"
        class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 dark:text-gray-400 dark:hover:text-white"
      >
        <SvgIcon
          v-if="link.icon"
          class="h-6 w-6 shrink-0"
          :name="link.icon"
        />
        {{ link.label }}
      </component>
    </template>
  </li>
</template>
