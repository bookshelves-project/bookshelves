import { defineStore } from 'pinia'

export interface StatisticsApi {
  new: number
  libraries: number
  movies: number
  tv_shows: number
}

export interface Statistics {
  new: {
    label: string
    value: number
  }
  movies: {
    label: string
    value: number
  }
  tv_shows: {
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
        label: 'new releases',
        value: data.new,
      },
      movies: {
        label: 'absolutely fascinating movies*',
        value: data.movies,
      },
      tv_shows: {
        label: 'totally overwhelming TV shows*',
        value: data.tv_shows,
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
