<template>
  <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex flex-col flex-grow bg-cyan-700 pt-5 pb-4 overflow-y-auto">
      <inertia-link
        :href="route('admin.dashboard')"
        class="flex items-center flex-shrink-0 px-4"
      >
        <app-logo />
      </inertia-link>
      <nav
        class="mt-5 flex-1 flex flex-col divide-y divide-cyan-800 overflow-y-auto"
        aria-label="Sidebar"
      >
        <div class="px-2 space-y-1">
          <div v-for="(item, index) in mainNav" :key="index">
            <inertia-link
              v-if="isLink(item)"
              :href="item.href"
              :class="
                item.active()
                  ? 'bg-cyan-800 text-white'
                  : 'text-cyan-100 hover:text-white hover:bg-cyan-600'
              "
              class="group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md"
              :aria-current="item.active() ? 'page' : undefined"
            >
              <component
                :is="item.icon"
                class="mr-4 flex-shrink-0 h-6 w-6 text-cyan-200"
                aria-hidden="true"
              />
              {{ item.text }}
            </inertia-link>
            <h3
              v-if="isTitle(item)"
              class="text-cyan-200 text-xs uppercase font-bold pt-4 pb-2 border-cyan-200 border-b-1"
            >
              {{ item.title }}
            </h3>
          </div>
          <!-- <div v-for="(link, i) in mainNav" :key="i" class="mb-4 group">
            <inertia-link
              v-if="isLink(link)"
              class="flex items-center py-3"
              :href="link.href"
              :class="{ active: link.active() }"
            >
              <component
                :is="link.icon"
                class="mr-4 flex-shrink-0 h-6 w-6 text-cyan-200"
                aria-hidden="true"
              />
              {{ link.text }}
            </inertia-link>
            <h3
              v-if="isTitle(link)"
              class="text-primary-300 text-xs uppercase font-bold pt-4 pb-2 border-primary-300 border-b-1"
            >
              {{ link.title }}
            </h3>
          </div> -->
          <!-- <a
            v-for="item in store.navigation"
            :key="item.name"
            :href="item.href"
            :class="[
              item.current
                ? 'bg-cyan-800 text-white'
                : 'text-cyan-100 hover:text-white hover:bg-cyan-600',
              'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md',
            ]"
            :aria-current="item.current ? 'page' : undefined"
          >
            <component
              :is="item.icon"
              class="mr-4 flex-shrink-0 h-6 w-6 text-cyan-200"
              aria-hidden="true"
            />
            {{ item.name }}
          </a> -->
        </div>
        <!-- <div class="mt-6 pt-6">
          <div class="px-2 space-y-1">
            <a
              v-for="item in store.secondaryNavigation"
              :key="item.name"
              :href="item.href"
              class="group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md text-cyan-100 hover:text-white hover:bg-cyan-600"
            >
              <component
                :is="item.icon"
                class="mr-4 h-6 w-6 text-cyan-200"
                aria-hidden="true"
              />
              {{ item.name }}
            </a>
          </div>
        </div> -->
      </nav>
    </div>
  </div>
</template>

<script setup lang="ts">
  import route from 'ziggy-js'
  import { mainNav, isTitle, isLink } from '@admin/_nav'
  import { useIndexStore } from '@admin/stores'

  const store = useIndexStore()
</script>
