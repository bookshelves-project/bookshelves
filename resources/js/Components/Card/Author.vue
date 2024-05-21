<script lang="ts" setup>
defineProps<{
  author: App.Models.Author
}>()
</script>

<template>
  <ILink :href="$route('authors.show', { author: author.slug })">
    <AppImg
      class="poster h-[20rem] w-full"
      :src="author.cover_thumbnail"
      :color="author.cover_color"
      :alt="author.name"
    />
    <div class="mt-3">
      <p class="line-clamp-1 w-48">
        {{ author.lastname }} {{ author.firstname }}
      </p>
      <p
        class="text-xs text-gray-200 line-clamp-1"
      >
        {{ author.name }}
      </p>
      <p class="line-clamp-1 text-sm text-gray-400">
        {{ author.books_count }} books, {{ author.series_count }} series
      </p>
    </div>
  </ILink>
</template>
