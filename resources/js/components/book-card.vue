<template>
  <article>
    <img :alt="book.title" :src="book.cover" v-if="book.cover" class="cover" />
    <img
      v-else
      src="images/bookshelves.svg"
      alt="bookshelves-default"
      class="cover"
    />
    <!-- <div class="px-1 my-1">
    <a :href="book.path">
      <article class="overflow-hidden rounded-lg shadow-lg">
        <img
          :alt="book.title"
          class="block w-full h-auto"
          :src="book.cover"
          v-if="book.cover"
        />
        <img v-else src="images/bookshelves.svg" alt="bookshelves-default" />
        {{ book.cover }}

        <a :href="`download/${book.slug}`">download</a>
        <header
          class="flex items-center justify-between p-2 leading-tight md:p-4"
        >
          <h1 class="text-lg">
            <a class="text-black no-underline hover:underline" href="#">
              {{ book.title }}
            </a>
          </h1>
        </header>

        <footer
          class="flex items-center justify-between p-2 leading-none md:p-4"
        >
          <a
            class="flex items-center text-black no-underline hover:underline"
            href="#"
          >
            <img
              alt="Placeholder"
              class="block rounded-full"
              src="https://picsum.photos/32/32/?random"
            />
            <p class="ml-2 text-sm">
              {{ book.creator }}
            </p>
          </a>
          <a class="no-underline text-grey-darker hover:text-red-dark" href="#">
            <span class="hidden">Like</span>
            <i class="fa fa-heart"></i>
          </a>
        </footer>
      </article>
    </a>
  </div> -->
  </article>
</template>

<script>
export default {
  name: 'BookCard',
  props: {
    book: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    download() {
      return this.book.path
    },
  },
}
</script>

<style lang="postcss" scoped>
.cover {
  @apply object-cover w-full h-full rounded-md;
}
</style>
