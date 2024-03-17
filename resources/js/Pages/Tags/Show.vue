<script lang="ts" setup>
defineProps<{
  title: string
}>()
</script>

<template>
  <App
    :title="title"
    icon="tag"
  >
    <div class="main-container">
      <p>Soon!</p>
    </div>
  </App>
</template>
