<script lang="ts" setup>
defineProps<{
  authors: App.Models.Author[]
}>()
</script>

<template>
  <App>
    <section class="main-container video-list">
      <CardAuthor
        v-for="author in authors"
        :key="author.id"
        :author="author"
      />
    </section>
  </App>
</template>
