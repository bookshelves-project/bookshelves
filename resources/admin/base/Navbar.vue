<template>
  <nav class="bg-white sm:border-b sm:border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8 bg-primary sm:bg-transparent">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="flex-shrink-0 flex items-center sm:hidden">
            <inertia-link :href="route('admin.dashboard')">
              <app-logo class="w-12 h-12" primary="#BBB" secondary="#FFF" />
            </inertia-link>
          </div>

          <!-- Navigation Links -->
          <div class="hidden sm:-my-px sm:flex sm:items-center">
            <div class="relative">
              <input
                ref="globalSearchInput"
                v-model="globalSearch"
                type="text"
                class="w-96"
                :placeholder="$t('admin.actions.search')"
              />
              <search-icon
                class="
                  h-5
                  w-5
                  absolute
                  top-1/2
                  right-4
                  transform
                  -translate-y-1/2
                  opacity-50
                "
              />
            </div>
          </div>
        </div>

        <div
          class="hidden sm:flex sm:items-center sm:ml-6"
          :class="{ 'bg-yellow-300': $page.props.auth.is_impersonating }"
        >
          <!-- Settings Dropdown -->
          <div class="relative">
            <dropdown>
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="
                      inline-flex
                      items-center
                      px-3
                      py-2
                      border border-transparent
                      text-sm
                      leading-4
                      font-medium
                      rounded-md
                      focus:outline-none
                      transition
                    "
                  >
                    {{ $page.props.auth.name }}

                    <chevron-down-icon class="h-4 w-4 ml-2" />
                  </button>
                </span>
              </template>

              <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  {{ $t('Manage Account') }}
                </div>

                <dropdown-link :href="route('admin.profile.show')" icon="user">
                  {{ $t('Profile') }}
                </dropdown-link>

                <div class="border-t border-gray-100"></div>

                <!-- Authentication -->
                <dropdown-link
                  v-if="$page.props.auth.is_impersonating"
                  icon="lock-open"
                  class="bg-yellow-300 hover:bg-yellow-500"
                  @click="stopImpersonate"
                >
                  {{ $t('Stop impersonate') }}
                </dropdown-link>

                <!-- Authentication -->
                <dropdown-link icon="logout" @click="logout">
                  {{ $t('Log Out') }}
                </dropdown-link>
              </template>
            </dropdown>
          </div>
        </div>

        <!-- Hamburger -->
        <div class="-mr-2 flex items-center sm:hidden">
          <button
            class="
              inline-flex
              items-center
              justify-center
              p-2
              rounded-md
              text-white
              sm:text-gray-400
              hover:text-gray-500 hover:bg-gray-100
              focus:outline-none focus:bg-gray-100 focus:text-gray-500
              transition
            "
            @click="showingNavigationDropdown = !showingNavigationDropdown"
          >
            <x-icon v-if="showingNavigationDropdown" class="h-6 w-6" />
            <menu-icon v-else class="h-6 w-6" />
          </button>
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
      :class="{
        block: showingNavigationDropdown,
        hidden: !showingNavigationDropdown,
      }"
      class="sm:hidden"
    >
      <div class="pt-2 pb-3 space-y-1">
        <responsive-nav-link
          v-for="(link, i) in nav"
          :key="i"
          :href="link.href"
          :active="link.active()"
        >
          {{ link.text }}
        </responsive-nav-link>
      </div>

      <!-- Responsive Settings Options -->
      <div class="pt-4 pb-1 border-t border-gray-200">
        <div class="flex items-center px-4">
          <div>
            <div class="font-medium text-base text-gray-800">
              {{ $page.props.auth.name }}
            </div>
            <div class="font-medium text-sm text-gray-500">
              {{ $page.props.auth.email }}
            </div>
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <responsive-nav-link
            :href="route('admin.profile.show')"
            :active="route().current('admin.profile.show')"
          >
            {{ $t('Profile') }}
          </responsive-nav-link>

          <!-- Authentication -->
          <responsive-nav-link @click="logout">
            {{ $t('Log Out') }}
          </responsive-nav-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script lang="ts" setup>
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
</script>
