<template>
  <div class="flex-shrink-0">
    <div class="px-2">
      <inertia-link
        :href="route('admin.dashboard')"
        class="group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md hover:bg-primary-800 transition-colors duration-75"
      >
        <app-logo class="!m-0" color="text-primary-600" full reverse />
      </inertia-link>
    </div>
  </div>
  <nav
    class="mt-5 flex-1 flex flex-col divide-y divide-primary-800 overflow-y-auto"
    aria-label="Sidebar"
  >
    <div class="px-2 space-y-1">
      <div v-for="(item, index) in mainNav" :key="index">
        <component
          :is="item.external ? 'a' : 'inertia-link'"
          v-if="isLink(item)"
          :href="item.href"
          :target="item.external ? '_blank' : '_self'"
          :rel="item.external ? 'noopener noreferrer' : ''"
          :class="
            item.active()
              ? 'bg-primary-800 text-white'
              : 'text-primary-100 hover:text-white hover:bg-primary-600'
          "
          class="group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md"
          :aria-current="item.active() ? 'page' : undefined"
        >
          <component
            :is="item.icon"
            class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200"
            aria-hidden="true"
          />
          {{ item.text }}
        </component>
        <h3
          v-if="isTitle(item)"
          class="text-primary-200 text-xs uppercase font-bold pt-4 pb-2 border-primary-200 border-b-1 mb-2"
        >
          {{ item.title }}
        </h3>
      </div>
    </div>
    <!-- <div class="mt-6 pt-6">
          <div class="px-2 space-y-1">
            <a
              v-for="item in store.secondaryNavigation"
              :key="item.name"
              :href="item.href"
              class="group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md text-primary-100 hover:text-white hover:bg-primary-600"
            >
              <component
                :is="item.icon"
                class="mr-4 h-6 w-6 text-primary-200"
                aria-hidden="true"
              />
              {{ item.name }}
            </a>
          </div>
        </div> -->
  </nav>
  <div class="mt-5 divide-primary-800" aria-label="Sidebar">
    <div class="px-2 space-y-1">
      <inertia-link
        :href="route('front.home')"
        target="_blank"
        rel="noopener noreferrer"
        class="link link-hover"
      >
        <component
          :is="BeakerIcon"
          class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200"
          aria-hidden="true"
        />
        Back to Features
      </inertia-link>
    </div>
  </div>
</template>

<script setup lang="ts">
  import route from 'ziggy-js'
  import { mainNav, isTitle, isLink } from '@admin/_nav'
  import { BeakerIcon } from '@heroicons/vue/outline'
</script>

<style lang="css" scoped>
  .link {
    @apply flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md;
  }
  .link-hover {
    @apply text-primary-100 hover:text-white hover:bg-primary-600;
  }
</style>
