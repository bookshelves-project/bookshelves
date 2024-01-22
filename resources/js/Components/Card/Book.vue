<script lang="ts" setup>
defineProps<{
  book: App.Models.Book
}>()
</script>

<template>
  <ILink :href="$route('books.show', { book_slug: book.slug })">
    <img
      class="poster h-64 mx-auto"
      :src="book.cover_thumbnail"
      loading="lazy"
      :alt="book.title"
    >
    <div class="mt-3">
      <p class="line-clamp-2 text-center">
        {{ book.title }}
      </p>
      <p>
        {{ book.serie?.title }} {{ book.volume_pad }}
      </p>
      <p>
        {{ book.authors?.map((author) => author.name).join(', ') }}
      </p>
    </div>
  </ILink>
</template>
