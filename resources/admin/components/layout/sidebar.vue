<template>
  <TransitionRoot as="template" :show="sidebarOpen">
    <Dialog
      as="div"
      class="fixed inset-0 flex z-40 lg:hidden"
      @close="store.closeSidebar()"
    >
      <TransitionChild
        as="template"
        enter="transition-opacity ease-linear duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="transition-opacity ease-linear duration-300"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
      </TransitionChild>
      <TransitionChild
        as="template"
        enter="transition ease-in-out duration-300 transform"
        enter-from="-translate-x-full"
        enter-to="translate-x-0"
        leave="transition ease-in-out duration-300 transform"
        leave-from="translate-x-0"
        leave-to="-translate-x-full"
      >
        <div
          class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-cyan-700"
        >
          <TransitionChild
            as="template"
            enter="ease-in-out duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="ease-in-out duration-300"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <div class="absolute top-0 right-0 -mr-12 pt-2">
              <button
                type="button"
                class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                @click="store.closeSidebar()"
              >
                <span class="sr-only">Close sidebar</span>
                <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
              </button>
            </div>
          </TransitionChild>
          <div class="flex-shrink-0 flex items-center px-4">
            <inertia-link
              :href="route('admin.dashboard')"
              class="flex items-center flex-shrink-0 px-4"
            >
              <app-logo />
            </inertia-link>
          </div>
          <nav
            class="mt-5 flex-shrink-0 h-full divide-y divide-cyan-800 overflow-y-auto"
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
            </div>
            <div class="mt-6 pt-6">
              <div class="px-2 space-y-1">
                <!-- <a
                  v-for="item in store.secondaryNavigation"
                  :key="item.name"
                  :href="item.href"
                  class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-cyan-100 hover:text-white hover:bg-cyan-600"
                >
                  <component
                    :is="item.icon"
                    class="mr-4 h-6 w-6 text-cyan-200"
                    aria-hidden="true"
                  />
                  {{ item.name }}
                </a> -->
              </div>
            </div>
          </nav>
        </div>
      </TransitionChild>
      <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
  import { mainNav, isTitle, isLink } from '@admin/_nav'
  import { useIndexStore } from '@admin/stores'
  import {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
  } from '@headlessui/vue'
  import { computed } from 'vue'

  const store = useIndexStore()

  const sidebarOpen = computed(() => {
    return store.sidebar
  })
</script>
