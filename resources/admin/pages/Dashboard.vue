<template>
  <app-layout :title="title">
    <dashboard-content />
    <DoughnutChart v-bind="doughnutChartProps" />
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
    chart: ChartModel
  }>()

  const title = useTitle('Dashboard')
  Chart.register(...registerables)

  let colors = useEnums().getChartColors()

  const testData = computed<ChartData<'doughnut'>>(() => ({
    labels: props.chart?.labels,
    datasets: [
      {
        data: props.chart?.values,
        backgroundColor: Object.values(colors),
      },
    ],
  }))

  const options = computed<ChartOptions<'doughnut'>>(() => ({
    plugins: {
      legend: {
        position: 'bottom',
      },
      title: {
        display: true,
        text: 'Entities',
      },
    },
  }))

  const { doughnutChartProps } = useDoughnutChart({
    chartData: testData,
    options,
  })
</script>
