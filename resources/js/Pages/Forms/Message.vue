<script lang="ts" setup>

</script>

<template>
  <App
    title="Message"
    icon="mail"
  >
    <main class="main-container grid grid-cols-1 py-10 lg:grid-cols-2 form">
      <div class="relative px-6 pb-4 pt-5 sm:pt-5 lg:static lg:px-8 lg:py-6">
        <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
          <h2 class="text-3xl font-bold tracking-tight text-white">
            A demand or a feedback?
          </h2>
          <p class="mt-6 text-lg leading-8 text-gray-300">
            You can ask for a new book, or a feature. You can also report a bug or give us a feedback.
          </p>
        </div>
      </div>
      <div class="px-6 pb-4 pt-4 sm:pb-5 lg:px-8 lg:py-6">
        <FormMessage />
      </div>
    </main>
  </App>
</template>

<style lang="css" scoped>
.form :deep(.large) {
  @apply col-span-2;
}
</style>
