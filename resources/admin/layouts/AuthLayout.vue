<template>
  <div
    class="
      min-h-screen
      flex flex-col
      justify-center
      items-center
      bg-primary-400
      px-6
    "
  >
    <div
      class="
        w-full
        sm:max-w-md
        px-6
        py-4
        bg-white
        shadow-md
        overflow-hidden
        rounded-lg
      "
    >
      <a href="/" class="block mb-8">
        <app-logo class="w-16 h-16 mx-auto" />
      </a>
      <slot />
    </div>
  </div>
</template>
