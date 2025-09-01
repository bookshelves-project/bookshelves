import { defineStore } from 'pinia'

export interface StatisticsApi {
  recently_added_books: number
  audiobook: number
  book: number
  graphic: number
}

export interface Statistics {
  recently_added_books: {
    label: string
    value: number
  }
  audiobook: {
    label: string
    value: number
  }
  book: {
    label: string
    value: number
  }
  graphic: {
    label: string
    value: number
  }
}

export const useHomeStatisticsStore = defineStore('home-statistics', () => {
  const statistics = ref<Statistics>()
  const ready = ref(false)

  function setStatistics(data: StatisticsApi) {
    statistics.value = {
      recently_added_books: {
        label: 'new books',
        value: data.recently_added_books,
      },
      audiobook: {
        label: 'amazing audiobooks',
        value: data.audiobook,
      },
      book: {
        label: 'incredible books',
        value: data.book,
      },
      graphic: {
        label: 'fantastic comics & manga',
        value: data.graphic,
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
