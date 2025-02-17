import { defineStore } from 'pinia'

export interface StatisticsApi {
  new: number
  books: number
  series: number
}

export interface Statistics {
  new: {
    label: string
    value: number
  }
  books: {
    label: string
    value: number
  }
  series: {
    label: string
    value: number
  }
}

export const useHomeStatisticsStore = defineStore('home-statistics', () => {
  const statistics = ref<Statistics>()
  const ready = ref(false)

  function setStatistics(data: StatisticsApi) {
    statistics.value = {
      new: {
        label: 'new books',
        value: data.new,
      },
      books: {
        label: 'incredible books*',
        value: data.books,
      },
      series: {
        label: 'absolutely epic series*',
        value: data.series,
      },
    }
    ready.value = true
  }

  return {
    statistics,
    ready,
    setStatistics,
  }
})
