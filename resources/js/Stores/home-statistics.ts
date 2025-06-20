import { defineStore } from 'pinia'

export interface StatisticsApi {
  recently_added_books: number
  audiobook: number
  book: number
  comic_manga: number
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
  comic_manga: {
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
      comic_manga: {
        label: 'fantastic comics & manga',
        value: data.comic_manga,
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
