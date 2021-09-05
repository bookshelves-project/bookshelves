<template>
  <div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex-1 flex flex-col min-h-0 bg-gray-800">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
          <div class="flex items-center flex-shrink-0 px-4">
            <div class="text-3xl font-handlee text-white h-8 w-auto">
              {{ $inertia.page.props.app.name }}
            </div>
          </div>
          <nav class="mt-5 flex-1 px-2 bg-gray-800 space-y-1">
            <nav-menu
              v-for="item in adminNavigation"
              :key="item.name"
              :item="item"
            />
            <hr />
            <nav-menu
              v-for="item in userNavigation"
              :key="item.name"
              :item="item"
            />
            <hr />
            <nav-menu
              v-for="item in devNavigation"
              :key="item.name"
              :item="item"
            />
          </nav>
        </div>
        <a
          :href="route('login')"
          class="
            flex-shrink-0 flex
            bg-gray-700
            hover:bg-gray-800
            transition-colors
            duration-100
            text-white
            p-4
          "
        >
          <LockOpenIcon class="w-6 h-6" />
          <p class="ml-2">Admin</p>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
name: "StaticSidebar";
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
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
} from "@heroicons/vue/outline";
import { SearchIcon } from "@heroicons/vue/solid";
import { LockOpenIcon } from "@heroicons/vue/outline";
import { Head, Link } from "@inertiajs/inertia-vue3";
import NavMenu from "@/Layouts/nav/nav-menu.vue";
const props = defineProps({
  adminNavigation: Array,
  userNavigation: Array,
  devNavigation: Array,
});
</script>
