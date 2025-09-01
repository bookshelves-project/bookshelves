<script lang="ts" setup>
defineProps<{
  authors?: App.Models.Author[]
  language?: App.Models.Language
}>()
</script>

<template>
  <div
    v-if="authors"
    class="flex flex-wrap"
  >
    <span class="mr-1">Written by </span>
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
    <span class="ml-1">in <strong>{{ language?.name }}</strong></span>
  </div>
</template>
