<script lang="ts" setup>
import type { StatisticsApi } from '@/Stores/home-statistics'
import { useHomeStatisticsStore } from '@/Stores/home-statistics'
import { useFetch } from '@kiwilan/typescriptable-laravel'

const stats = useHomeStatisticsStore()

async function asyncData() {
  if (stats.ready) {
    return
  }

  const { laravel } = useFetch()
  const res = await laravel.get('api.live.statistics')
  const body = await res.getBody<StatisticsApi>()

  if (!body) {
    console.warn('Failed to fetch statistics')
    return
  }

  stats.setStatistics(body)
}

onMounted(() => {
  asyncData()
})
</script>

<template>
  <div class="py-8 sm:py-10">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:max-w-none">
        <div class="text-center">
          <h2 class="text-balance text-2xl font-semibold tracking-tight text-white sm:text-3xl">
            Hundreds of pirates already trust us
          </h2>
          <p class="mt-4 text-lg/8 text-gray-300">
            Quality service for quality people.
          </p>
        </div>
        <dl class="mt-6 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center lg:grid-cols-4">
          <template v-if="stats.ready">
            <div
              v-for="statistic in stats.statistics"
              :key="statistic.label"
              class="flex flex-col bg-white/5 p-8"
            >
              <dt class="statistic-label my-1">
                {{ statistic.label }}
              </dt>
              <dd class="statistic-value my-1">
                {{ statistic.value }}
              </dd>
            </div>
          </template>
          <template v-else>
            <div
              v-for="i in 4"
              :key="i"
              class="animate-pulse w-full h-36 bg-gray-800"
            />
          </template>
        </dl>
      </div>
      <div class="pt-4 text-xs">
        <em>In line with current policy, according to 60 million pirates magazine.</em>
      </div>
    </div>
  </div>
</template>

<style lang="css" scoped>
.statistic-label {
  @apply text-sm/6 font-semibold text-gray-300;
}
.statistic-value {
  @apply order-first text-3xl font-semibold tracking-tight text-white;
}
.loading {
  @apply bg-gray-700 animate-pulse mx-auto rounded-xl;
}
</style>
