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
    <!-- <div class="mt-3">
      <p class="line-clamp-2">
        {{ author.name }}
      </p>
    </div> -->
    <div class="mt-3">
      <p class="line-clamp-1">
        {{ author.name }}
      </p>
      <p
        v-if="author.books_count && author.series_count"
        class="text-xs text-gray-400 line-clamp-1"
      >
        {{ author.books_count }} books, {{ author.series_count }} series
      </p>
    </div>
  </ILink>
</template>
