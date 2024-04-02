<script lang="ts" setup>

</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <div class="pt-10 space-y-6">
      hello
      <SwiperHome
        endpoint="api.books.latest"
        title="Books recently added"
        type="book"
      />
      <SwiperHome
        endpoint="api.books.released"
        title="Books recently released"
        type="book"
      />
      <SwiperHome
        endpoint="api.series.latest"
        title="Series recently added"
        type="serie"
      />
    </div>
  </App>
</template>
