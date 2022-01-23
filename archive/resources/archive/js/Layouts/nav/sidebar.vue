<template>
  <TransitionRoot as="template" :show="toggle">
    <Dialog
      as="div"
      class="fixed inset-0 flex z-40 md:hidden"
      @close="toggle = false"
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
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
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
                @click="sidebarOpen = false"
              >
                <span class="sr-only">Close sidebar</span>
                <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
              </button>
            </div>
          </TransitionChild>
          <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 flex items-center px-4">
              <div class="text-3xl font-handlee text-white h-8 w-auto">
                {{ $inertia.page.props.app.name }}
              </div>
            </div>
            <nav class="mt-5 px-2 space-y-1">
              <a href="http://"></a>
              <a
                v-for="item in navigation"
                :key="item.name"
                :href="item.href ? route(item.href) : item.link"
                :target="item.external ? '_blank' : ''"
                :rel="item.external ? 'noopener noreferrer' : ''"
                :class="[
                  item.current
                    ? 'bg-gray-900 text-white'
                    : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                  'group flex items-center px-2 py-2 text-base font-medium rounded-md',
                ]"
              >
                <component
                  :is="item.icon"
                  :class="[
                    item.current
                      ? 'text-gray-300'
                      : 'text-gray-400 group-hover:text-gray-300',
                    'mr-4 flex-shrink-0 h-6 w-6',
                  ]"
                  aria-hidden="true"
                />
                {{ item.name }}
              </a>
            </nav>
          </div>
          <a
            :href="route('admin.login')"
            class="flex-shrink-0 flex bg-gray-700 hover:bg-gray-800 transition-colors duration-100 text-white p-4"
          >
            <LockOpenIcon class="w-6 h-6" />
            <p class="ml-2">Admin</p>
          </a>
        </div>
      </TransitionChild>
      <div class="flex-shrink-0 w-14">
        <!-- Force sidebar to shrink to fit close icon -->
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
'Sidebar'
import { ref, watch, reactive, watchEffect } from 'vue'
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  BellIcon,
  CalendarIcon,
  ChartBarIcon,
  FolderIcon,
  HomeIcon,
  InboxIcon,
  MenuAlt2Icon,
  UsersIcon,
  XIcon,
} from '@heroicons/vue/outline'
import { SearchIcon } from '@heroicons/vue/solid'
import { LockOpenIcon } from '@heroicons/vue/outline'
import { Head, Link } from '@inertiajs/inertia-vue3'
const props = defineProps({
  navigation: Array,
  toggle: Boolean,
})
const toggle = ref(false)
watch(
  () => props.toggle,
  (current, prev) => {
    toggle.value = true
  }
)
</script>
