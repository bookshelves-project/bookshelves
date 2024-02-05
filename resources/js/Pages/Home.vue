<script lang="ts" setup>

</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <SwiperHome
      endpoint="api.books.latest"
      title="Books recently added"
      type="book"
    />
    <SwiperHome
      endpoint="api.series.latest"
      title="Series recently added"
      type="serie"
    />
  </App>
</template>
