<script lang="ts" setup>
defineProps<{
  book: App.Models.Book
}>()
</script>

<template>
  <App>
    <pre>{{ book }}</pre>
  </App>
</template>
