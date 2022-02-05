<template>
  <main class="flex-1 pb-8">
    <div class="mt-8">
      <div class="px-4 sm:px-6 lg:px-8">
        <slot></slot>
      </div>
    </div>
    <slot name="aside"></slot>
  </main>
</template>
