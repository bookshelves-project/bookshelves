<script lang="ts" setup>
import type { Swiper } from '@/Stores/home-swiper'
import { useInstance } from '@/Composables/useInstance'

defineProps<{
  swiper: Swiper
}>()

const { toBooks, toSeries } = useInstance()
</script>

<template>
  <div>
    <SwiperBooks
      v-if="swiper.type === 'book'"
      :books="toBooks(swiper.items)"
      :title="swiper.title"
      :link="swiper.link"
      :square="swiper.square"
      :ready="swiper.items.length > 0"
      padding
    />
    <SwiperSeries
      v-else-if="swiper.type === 'serie'"
      :series="toSeries(swiper.items)"
      :title="swiper.title"
      :link="swiper.link"
      :ready="swiper.items.length > 0"
      padding
    />
  </div>
</template>
