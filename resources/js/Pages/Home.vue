<script lang="ts" setup>
import { useNotification } from '@/Composables/useNotification'

// const search = ref<string>()
const { push } = useNotification()
</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <div class="pt-10 space-y-6">
      <button @click="push({ title: 'Hello!' })">
        notif
      </button>
      <button @click="push({ title: 'Hello2' })">
        notif 2
      </button>
      <button @click="push({ title: 'Hello3' })">
        notif 3
      </button>
      <!-- <input
        v-model.lazy="search"
        class="bg-gray-700"
      > -->
      <!-- <SwiperHome
        endpoint="api.books.latest"
        title="Books recently added"
        type="book"
      /> -->
      <!-- <SwiperHome
        endpoint="api.books.released"
        title="Books recently released"
        type="book"
      /> -->
      <!-- <SwiperHome
        endpoint="api.series.latest"
        title="Series recently added"
        type="serie"
      /> -->
    </div>
  </App>
</template>
