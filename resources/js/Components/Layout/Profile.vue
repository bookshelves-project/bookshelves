<script lang="ts" setup>
import { useNavigation } from '@/Composables/useNavigation'
import { usePage } from '@inertiajs/vue3'
import { useFetch, useSlideover } from '@kiwilan/typescriptable-laravel'

const page = usePage()
const { inertia } = useFetch()

const { open, close } = useSlideover()
const { profileLinks } = useNavigation()

const user = ref<App.Models.User>((page.props.auth as any)?.user)

function logout() {
  close()
  inertia.post('logout')
}
</script>

<template>
  <div class="w-16 md:w-40 self-stretch border-l border-white/5">
    <button
      v-if="user"
      class="h-full w-full hover:bg-gray-700/30"
      title="Profile"
      @click="open"
    >
      <div class="mx-auto flex w-max items-center space-x-1">
        <SvgIcon
          name="user"
          class="h-5 w-5"
        />
        <span class="hidden md:block">{{ user.name }}</span>
      </div>
    </button>
    <AppSlideOver title="Profile">
      <div class="w-full px-1">
        <ul
          class="-mx-2 space-y-1"
          role="list"
        >
          <LayoutSidebarLink
            v-for="link in profileLinks"
            :key="link.label"
            :link="link"
            hover="hover:bg-gray-700"
            active="bg-gray-700 text-white"
            @click="close"
          />
          <form @submit.prevent="logout">
            <button
              type="submit"
              class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-700 hover:text-white w-full"
            >
              <SvgIcon
                class="h-6 w-6 shrink-0"
                name="sign-out"
              />
              Log Out
            </button>
          </form>
        </ul>
      </div>
    </AppSlideOver>
  </div>
</template>

<style lang="css" scoped>
.link {
  @apply w-full rounded-sm px-2 py-1 hover:bg-gray-800 flex items-center space-x-1;
}
</style>
