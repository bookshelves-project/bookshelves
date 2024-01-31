<script lang="ts" setup>
import 'vue3-toastify/dist/index.css'
</script>

<template>
  <main class="main-container grid grid-cols-1 py-10 lg:grid-cols-2 form">
    <div class="relative px-6 pb-4 pt-5 sm:pt-5 lg:static lg:px-8 lg:py-6">
      <slot name="list" />
    </div>
    <div class="px-6 pb-4 pt-4 sm:pb-5 lg:px-8 lg:py-6">
      <slot name="form" />
    </div>
  </main>
</template>

<style lang="css" scoped>
.form :deep(.large) {
  @apply col-span-2;
}
</style>
