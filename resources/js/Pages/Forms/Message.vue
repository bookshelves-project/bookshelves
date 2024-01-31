<script lang="ts" setup>

</script>

<template>
  <App
    title="Bug report"
    icon="bug"
  >
    <FormLayout>
      <template #list>
        <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
          <h2 class="text-3xl font-bold tracking-tight text-white">
            A demand or a feedback?
          </h2>
          <p class="mt-6 text-lg leading-8 text-gray-300">
            You can ask for a new movie, TV show, or a feature. You can also report a bug or give us a feedback.
          </p>
        </div>
      </template>
      <template #form>
        <FormMessage />
      </template>
    </FormLayout>
  </App>
</template>
