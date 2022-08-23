<script setup lang="ts">
defineProps<{
  title?: string
}>()
</script>

<template>
  <main-layout class="min-h-full">
    <sidebar />

    <!-- Static sidebar for desktop -->
    <sidebar-desktop />

    <div class="lg:pl-64 flex flex-col flex-1">
      <div
        scroll-region
        class="md:flex-1 md:overflow-y-auto scrollbar-thin scrollbar-thumb-primary-900 scrollbar-track-gray-100 dark:text-white dark:bg-gray-900 transition-colors duration-75"
      >
        <flash-messages />
        <div class="shadow">
          <app-header />

          <page-header :title="title">
            <slot name="header-actions" />
          </page-header>
        </div>

        <app-content>
          <slot />
        </app-content>
      </div>
      <slot name="aside" />
      <app-footer />
    </div>
  </main-layout>
</template>
