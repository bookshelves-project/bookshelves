<script lang="ts" setup>
defineProps<{
  authors?: App.Models.Author[]
}>()
</script>

<template>
  <div
    v-if="authors"
    class="flex flex-wrap"
  >
    <ILink
      v-for="(author, id) in authors"
      :key="author.id"
      :href="$route('authors.show', { author: author.slug })"
      class="link"
    >
      {{ author.name }}<span
        v-if="id < authors.length - 1"
        class="mr-1"
      >,</span>
    </ILink>
  </div>
</template>
