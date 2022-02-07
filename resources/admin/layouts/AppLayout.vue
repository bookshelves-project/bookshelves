<template>
  <div class="min-h-full">
    <sidebar />

    <!-- Static sidebar for desktop -->
    <sidebar-desktop />

    <div class="lg:pl-64 flex flex-col flex-1">
      <div
        scroll-region
        class="md:flex-1 md:overflow-y-auto scrollbar-thin scrollbar-thumb-primary-900 scrollbar-track-gray-100"
      >
        <flash-messages />
        <div class="shadow">
          <app-header />

          <page-header :title="title">
            <slot name="header-actions"></slot>
          </page-header>
        </div>

        <app-content>
          <slot></slot>
        </app-content>
      </div>
      <slot name="aside"></slot>
      <app-footer />
    </div>
  </div>
</template>

<script setup lang="ts">
  defineProps({
    title: String,
  })
</script>
