<template>
  <main class="flex-1 pb-8 min-h-[85vh]">
    <div class="mt-8">
      <div class="px-4 sm:px-6 lg:px-8">
        <slot></slot>
      </div>
    </div>
    <slot name="aside"></slot>
  </main>
</template>
