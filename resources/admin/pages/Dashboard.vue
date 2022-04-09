<template>
  <app-layout :title="title">
    <!-- <dashboard-content /> -->
    <div class="grid xl:grid-cols-2">
      <doughnut-chart :chart-data="entities" />
      <doughnut-chart :chart-data="users" />
    </div>
  </app-layout>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { DoughnutChart, useDoughnutChart } from 'vue-chart-3'
import { Chart, ChartData, ChartOptions, registerables } from 'chart.js'
import { useTitle } from '@admin/features/helpers'
import { ChartModel } from '@admin/types'
import { useEnums } from '@admin/composables/useEnums'

const props = defineProps<{
  chartEntities: ChartModel
  chartUsers: ChartModel
}>()

const title = useTitle('Dashboard')
Chart.register(...registerables)

let colors = useEnums().getChartColors()

const entities = computed<ChartData<'doughnut'>>(() => ({
  labels: props.chartEntities?.labels,
  datasets: [
    {
      data: props.chartEntities?.values,
      backgroundColor: Object.values(colors),
    },
  ],
}))

const users = computed<ChartData<'doughnut'>>(() => ({
  labels: props.chartUsers?.labels,
  datasets: [
    {
      data: props.chartUsers?.values,
      backgroundColor: Object.values(colors),
    },
  ],
}))

// const options = computed<ChartOptions<'doughnut'>>(() => ({
//   plugins: {
//     legend: {
//       position: 'bottom',
//     },
//     title: {
//       display: true,
//       text: 'Entities',
//     },
//   },
// }))

// useDoughnutChart({
//   entities,
//   options,
// })
// useDoughnutChart({
//   users,
//   options,
// })
</script>
