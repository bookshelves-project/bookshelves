<template>
  <div class="px-1 my-1">
    <a :href="book.path">
      <article class="overflow-hidden rounded-lg shadow-lg">
        <img alt="Placeholder" class="block w-full h-auto" :src="book.cover" />

        <header
          class="flex items-center justify-between p-2 leading-tight md:p-4"
        >
          <h1 class="text-lg">
            <a class="text-black no-underline hover:underline" href="#">
              {{ book.title }}
            </a>
          </h1>
          <!-- <p class="text-sm text-grey-darker">14/4/19</p> -->
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
  </div>
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

<style lang="postcss" scoped></style>
