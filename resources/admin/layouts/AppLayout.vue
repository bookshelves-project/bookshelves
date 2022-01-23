<template>
  <div class="h-screen md:flex md:flex-col bg-gray-100">
    <div class="md:flex md:flex-shrink-0">
      <div
        class="
          hidden
          sm:flex
          bg-primary-900
          md:flex-shrink-0 md:w-56
          px-6
          items-center
          justify-between
          md:justify-center
        "
      >
        <a href="/" target="_blank" class="mt-1">
          <app-logo class="block h-9 w-auto fill-white" />
        </a>
      </div>
      <navbar class="w-full" />
    </div>

    <div class="md:flex md:flex-grow md:overflow-hidden">
      <div
        class="
          hidden
          md:block
          bg-primary-800
          flex-shrink-0
          w-56
          px-8
          py-4
          overflow-y-auto
          scrollbar-thin scrollbar-thumb-primary-900 scrollbar-track-gray-100
        "
      >
        <sidebar-nav />
      </div>
      <div
        scroll-region
        class="
          md:flex-1 md:overflow-y-auto
          scrollbar-thin scrollbar-thumb-primary-900 scrollbar-track-gray-100
        "
        :class="{ 'hidden sm:block': !!$slots.aside }"
      >
        <!-- Page Heading -->
        <header v-if="$slots.header" class="bg-white shadow">
          <div class="py-6 px-4 sm:px-6 lg:px-8">
            <slot name="header"></slot>
          </div>
        </header>

        <flash-messages />

        <!-- Page Content -->
        <main class="px-4 py-8 md:p-8">
          <slot></slot>
        </main>
      </div>

      <slot name="aside"></slot>
    </div>
  </div>
</template>

<script lang="ts" setup></script>
