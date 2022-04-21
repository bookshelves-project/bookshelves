<template>
  <div class="relative z-10 flex-shrink-0 flex h-16">
    <button
      type="button"
      class="px-4 border-r border-gray-200 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden dark:border-gray-600 dark:text-gray-200"
      @click="sidebarOpen"
    >
      <span class="sr-only">Open sidebar</span>
      <MenuAlt1Icon class="h-6 w-6" aria-hidden="true" />
    </button>
    <!-- Search bar -->
    <div class="flex-1 px-4 flex justify-between sm:px-6 lg:px-8">
      <div class="flex-1 flex my-2">
        <form class="w-full flex md:ml-0" action="#" method="GET">
          <label for="search-field" class="sr-only">Search</label>
          <div class="relative w-full text-gray-400 focus-within:text-gray-600">
            <div
              class="absolute inset-y-0 left-2 flex items-center pointer-events-none"
              aria-hidden="true"
            >
              <SearchIcon class="h-5 w-5" aria-hidden="true" />
            </div>
            <input
              id="search-field"
              ref="globalSearchInput"
              v-model="globalSearch"
              name="search-field"
              type="search"
              class="block w-full h-full pl-9 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent sm:text-base dark:bg-gray-900 dark:text-white p-2 rounded-md"
              :placeholder="$t('admin.actions.search')"
            />
          </div>
        </form>
      </div>
      <div class="ml-4 flex items-center md:ml-6">
        <color-mode />
        <!-- Profile dropdown -->
        <Menu as="div" class="ml-3 relative">
          <div>
            <MenuButton
              class="max-w-xs rounded-full flex items-center text-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 lg:p-2 lg:rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
            >
              <!-- <img
                  class="h-8 w-8 rounded-full"
                  src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt=""
                /> -->
              <span
                class="hidden ml-3 text-gray-700 dark:text-gray-400 text-base font-medium lg:block"
                ><span class="sr-only">Open user menu for </span
                >{{ $page.props.auth.name }}</span
              >
              <ChevronDownIcon
                class="hidden flex-shrink-0 ml-1 h-5 w-5 text-gray-400 lg:block"
                aria-hidden="true"
              />
            </MenuButton>
          </div>
          <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <MenuItems
              class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none bg-white dark:bg-gray-800"
            >
              <MenuItem v-slot="{ active }">
                <inertia-link
                  :href="route('admin.profile.show')"
                  :class="[
                    active ? 'bg-gray-100 dark:bg-gray-700' : '',
                    'block px-4 py-2 text-base text-gray-700 dark:text-gray-300',
                  ]"
                  >{{ $t('Profile') }}</inertia-link
                >
              </MenuItem>
              <MenuItem v-if="$page.props.auth.is_impersonating">
                <button
                  :class="'block px-4 py-2 text-base text-gray-700 dark:text-gray-300'"
                  @click="stopImpersonate"
                >
                  {{ $t('Stop impersonate') }}
                </button>
              </MenuItem>
              <MenuItem>
                <button
                  :class="'block px-4 py-2 text-base text-gray-700 w-full text-left hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-300'"
                  @click="logout"
                >
                  {{ $t('Log Out') }}
                </button>
              </MenuItem>
            </MenuItems>
          </transition>
        </Menu>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { MenuAlt1Icon } from '@heroicons/vue/outline'
import { ChevronDownIcon, SearchIcon } from '@heroicons/vue/solid'
import { useIndexStore } from '@admin/stores'
import route from 'ziggy-js'
import { onMounted, Ref, ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

const globalSearch = ref(usePage().props.value.query)
const globalSearchInput: Ref<HTMLInputElement | null> = ref(null)

const logout = () => {
  Inertia.post(route('logout'))
}

const stopImpersonate = () => {
  Inertia.post(route('admin.users.stop-impersonate'))
}

watch(
  () => globalSearch.value,
  (val) =>
    Inertia.get(
      route('admin.search', { query: val }),
      {},
      {
        preserveState: true,
      }
    )
)

onMounted(() => {
  if (route().current('admin.search')) {
    globalSearchInput.value?.focus()
  }
})

const sidebarOpen = () => {
  let store = useIndexStore()
  store.toggleSidebar()
}
</script>
