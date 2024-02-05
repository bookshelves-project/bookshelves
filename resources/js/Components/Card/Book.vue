<script lang="ts" setup>
interface Props {
  book: App.Models.Book
  square?: boolean
  carousel?: boolean
}

withDefaults(defineProps<Props>(), {
  square: false,
})
</script>

<template>
  <ILink
    :href="$route('books.show', { book_slug: book.slug })"
    :title="book.title"
    class="relative"
  >
    <AppImg
      :class="{
        'poster ': !square,
        'album ': square,
        'h-[20rem]': carousel && !square,
        'h-[10rem]': carousel && square,
      }"
      class="w-full"
      :src="book.cover_thumbnail"
      :color="book.cover_color"
      :alt="book.title"
    />
    <div class="absolute bg-gradient-to-b from-gray-900/60 via-gray-900/30 to-white/0 h-20 w-full top-0 z-10" />
    <div
      v-if="book.language"
      class="info left-2 text-shadow"
    >
      {{ book.language.name }}
    </div>
    <div
      v-if="book.extension"
      class="info right-2 uppercase text-shadow"
    >
      {{ book.extension }}
    </div>
    <div class="mt-3">
      <p class="line-clamp-1">
        {{ book.title }}
      </p>
      <p
        v-if="book.serie"
        class="text-xs text-gray-200 line-clamp-1"
      >
        {{ book.serie.title }} #{{ book.volume_pad }}
      </p>
      <p class="line-clamp-1 text-sm text-gray-400">
        {{ book.authors?.map((author) => author.name).join(', ') }}
      </p>
    </div>
  </ILink>
</template>

<style lang="css" scoped>
.info {
  @apply absolute top-2 text-sm italic text-gray-200 z-20 font-semibold;
}
.text-shadow {
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 1);
}
</style>
