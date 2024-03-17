<script lang="ts" setup>
defineProps<{
  authors?: App.Models.Author[]
}>()
</script>

<template>
  <div
    v-if="authors"
    class="flex flex-wrap gap-3"
  >
    <ILink
      v-for="author in authors"
      :key="author.id"
      :href="$route('authors.show', { author: author.slug })"
      class="link"
    >
      {{ author.name }}
    </ILink>
  </div>
</template>
