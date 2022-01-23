<template>
  <div
    class="min-h-screen flex flex-col justify-center items-center bg-secondary-200 px-6"
  >
    <div class="w-full px-6 py-4 bg-white overflow-hidden rounded-lg">
      <div class="text-center">
        <a href="/" class="inline-block">
          <app-logo class="w-16 h-16" />
        </a>
      </div>
      <slot />
    </div>
  </div>
</template>
