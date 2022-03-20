<template>
  <div class="py-6 px-8 md:flex md:items-center md:justify-between">
    <div class="flex-1 min-w-0">
      <!-- Profile -->
      <div class="flex items-center">
        <!-- <img
            class="hidden h-16 w-16 rounded-full sm:block"
            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.6&w=256&h=256&q=80"
            alt=""
          /> -->
        <div>
          <div class="flex items-center">
            <!-- <img
                class="h-16 w-16 rounded-full sm:hidden"
                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.6&w=256&h=256&q=80"
                alt=""
              /> -->
            <h1
              class="ml-3 text-2xl font-semibold leading-7 text-gray-900 dark:text-gray-100 sm:leading-9 sm:truncate"
            >
              {{ $attrs.title }}
            </h1>
          </div>
          <!-- <dl
              class="mt-6 flex flex-col sm:ml-3 sm:mt-1 sm:flex-row sm:flex-wrap"
            >
              <dt class="sr-only">Company</dt>
              <dd
                class="flex items-center text-base text-gray-500 font-medium capitalize sm:mr-6"
              >
                <OfficeBuildingIcon
                  class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                  aria-hidden="true"
                />
                Duke street studio
              </dd>
              <dt class="sr-only">Account status</dt>
              <dd
                class="mt-3 flex items-center text-base text-gray-500 font-medium sm:mr-6 sm:mt-0 capitalize"
              >
                <CheckCircleIcon
                  class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400"
                  aria-hidden="true"
                />
                Verified account
              </dd>
            </dl> -->
        </div>
      </div>
    </div>
    <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
      <div class="flex gap-2 ml-auto">
        <slot />
      </div>
      <!-- <button
          type="button"
          class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
        >
          Add money
        </button>
        <button
          type="button"
          class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
        >
          Send money
        </button> -->
    </div>
  </div>
</template>

<script setup lang="ts">
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  import { BellIcon, MenuAlt1Icon } from '@heroicons/vue/outline'
  import { ChevronDownIcon, SearchIcon } from '@heroicons/vue/solid'
  import { useIndexStore } from '@admin/stores'
  import route from 'ziggy-js'
  import { NavLink, isLink, mainNav } from '@admin/_nav'
  import { onMounted, Ref, ref, watch } from 'vue'
  import { Inertia } from '@inertiajs/inertia'
  import { usePage } from '@inertiajs/inertia-vue3'

  const showingNavigationDropdown = ref(false)
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

  const nav = mainNav.filter((l) => isLink(l)) as NavLink[]
  const sidebarOpen = () => {
    let store = useIndexStore()
    store.toggleSidebar()
  }
</script>
