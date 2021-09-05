<template>
  <Head :title="title" />
  <div class="h-screen flex overflow-hidden bg-gray-100">
    <sidebar :admin-navigation="adminNavigation" :toggle="sidebarOpen" />
    <!-- Static sidebar for desktop -->
    <static-sidebar
      :admin-navigation="adminNavigation"
      :user-navigation="userNavigation"
      :dev-navigation="devNavigation"
    />

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
      <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
        <button
          type="button"
          class="
            px-4
            border-r border-gray-200
            text-gray-500
            focus:outline-none
            focus:ring-2
            focus:ring-inset
            focus:ring-indigo-500
            md:hidden
          "
          @click="sidebarOpen = !sidebarOpen"
        >
          <span class="sr-only">Open sidebar</span>
          <MenuAlt2Icon class="h-6 w-6" aria-hidden="true" />
        </button>
        <div class="flex-1 px-4 flex justify-between">
          <div class="flex-1 flex">
            <div class="w-full flex md:ml-0">
              <h1 class="text-2xl font-semibold text-gray-900 my-auto md:ml-5">
                {{ title }}
              </h1>
            </div>
          </div>
        </div>
      </div>

      <main class="flex-1 relative overflow-y-auto focus:outline-none">
        <div class="pt-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <!-- Replace with your content -->
            <div class="pt-4">
              <main class="min-h-screen">
                <slot />
              </main>
              <app-footer />
            </div>
            <!-- /End replace -->
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import {
  FolderIcon,
  HomeIcon,
  UsersIcon,
  MenuAlt2Icon,
} from "@heroicons/vue/outline";
import { Head, Link } from "@inertiajs/inertia-vue3";
import StaticSidebar from "@/Layouts/nav/static-sidebar.vue";
import Sidebar from "@/Layouts/nav/sidebar.vue";
import AppFooter from "@/components/layout/app-footer.vue";

const props = defineProps({
  title: String,
});
const adminNavigation = [
  { name: "Admin", href: "admin", icon: HomeIcon, current: true },
];
const userNavigation = [
  { name: "OPDS", href: "opds.index", icon: UsersIcon, current: false },
  { name: "Catalog", href: "catalog.index", icon: FolderIcon, current: false },
  {
    name: "Webreader",
    href: "webreader.index",
    icon: FolderIcon,
    current: false,
  },
];
const devNavigation = [
  { name: "Wiki", href: "wiki.index", icon: FolderIcon, current: false },
  {
    name: "API Doc",
    link: "docs",
    icon: FolderIcon,
    current: false,
    external: true,
  },
];
const sidebarOpen = ref(false);
</script>

<style lang="css">
.wrapper {
  min-height: 100vh;
}
.wrapper {
  display: flex;
  flex-direction: column;
}
.content {
  flex: 1 0 auto;
}
.footer {
  flex-shrink: 0;
}
</style>
