<script setup lang="ts">
import { computed } from 'vue'
import { DoughnutChart, useDoughnutChart } from 'vue-chart-3'
import type { ChartData, ChartOptions } from 'chart.js'
import { Chart, registerables } from 'chart.js'
import { useTitle } from '@admin/features/helpers'
import type { ChartModel } from '@admin/types'
import { useEnums } from '@admin/composables/useEnums'
import { useColorMode } from '@admin/composables/color-mode'

const props = defineProps<{
  chartEntities: ChartModel
  chartUsers: ChartModel
}>()

const title = useTitle('Dashboard')
const colorMode = useColorMode()

Chart.register(...registerables)

const colors = useEnums().getChartColors()

const entities = computed<ChartData<'doughnut'>>(() => ({
  labels: props.chartEntities?.labels,
  datasets: [
    {
      data: props.chartEntities?.values,
      backgroundColor: Object.values(colors),
      borderColor: colorMode.isDarkMode.value ? 'black' : 'white',
    },
  ],
}))

const users = computed<ChartData<'doughnut'>>(() => ({
  labels: props.chartUsers?.labels,
  datasets: [
    {
      data: props.chartUsers?.values,
      backgroundColor: Object.values(colors),
      borderColor: colorMode.isDarkMode.value ? 'black' : 'white',
    },
  ],
}))

const options = computed<ChartOptions<'doughnut'>>(() => ({
  plugins: {
    legend: {
      position: 'top',
      labels: {
        color: colorMode.isDarkMode.value ? 'white' : 'black',
      },
    },
  },
}))

// useDoughnutChart({
//   entities,
//   options,
// })
// useDoughnutChart({
//   users,
//   options,
// })
</script>

<template>
  <app-layout :title="title">
    <!-- <dashboard-content /> -->
    <div class="grid xl:grid-cols-2">
      <doughnut-chart
        :chart-data="entities"
        :options="options"
      />
      <doughnut-chart
        :chart-data="users"
        :options="options"
      />
    </div>
  </app-layout>
</template>
