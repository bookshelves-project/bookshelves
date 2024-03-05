<script lang="ts" setup>
defineProps<{
  author: App.Models.Author
}>()
</script>

<template>
  <ILink :href="$route('authors.show', { author_slug: author.slug })">
    <AppImg
      class="poster h-[20rem] w-full"
      :src="author.cover_thumbnail"
      :color="author.cover_color"
      :alt="author.name"
    />
    <div class="mt-3">
      <p class="line-clamp-2 text-center">
        {{ author.name }}
      </p>
    </div>
  </ILink>
</template>
