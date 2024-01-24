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
const { page } = useInertia()

const user = ref<App.Models.User>(page.props.auth?.user)

const href = computed(() => {
  if (props.link.route)
    return route(props.link.route.name, props.link.route.params)

  return props.link.url
})
</script>

<template>
  <li>
    <component
      :is="link.url ? 'a' : 'ILink'"
      v-if="!link.restrictedRoles || link.restrictedRoles.includes(user.role ?? '')"
      :href="href"
      :target="link.url ? '_blank' : null"
      :rel="link.url ? 'noopener noreferrer' : null"
      :class="[
        href === currentRoute?.path ? active : '',
        hover,
      ]"
      class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 dark:text-gray-400 dark:hover:text-white"
    >
      <SvgIcon
        class="h-6 w-6 shrink-0"
        :name="link.icon"
      />
      {{ link.label }}
    </component>
  </li>
</template>