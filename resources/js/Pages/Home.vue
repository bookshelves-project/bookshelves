<script lang="ts" setup>
import { useHomeSwiperStore } from '@/Stores/home-swiper'

const swiper = useHomeSwiperStore()

onMounted(() => {
  swiper.fetchSwipers()
})
</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <div class="py-6 space-y-6">
      <HomeHero />
      <HomeStatistics />
      <SwiperHome
        v-for="s in swiper.swipers"
        :key="s.route"
        :swiper="s"
      />
      <HomeFeatures />
    </div>
  </App>
</template>
