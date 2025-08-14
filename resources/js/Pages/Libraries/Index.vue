<script lang="ts" setup>
defineProps<{
  libraries?: App.Models.Library[]
  breadcrumbs?: any[]
}>()
</script>

<template>
  <App title="All libraries"
    icon="libraries">
    <div class="main-container relative z-10 py-6">
      <Breadcrumbs v-if="breadcrumbs"
        :breadcrumbs="breadcrumbs"
        class="hidden lg:block" />
      <LibraryList :libraries="libraries"
        class="mt-8" />
    </div>
  </App>
</template>
