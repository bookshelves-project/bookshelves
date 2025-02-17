import { defineStore } from 'pinia'

export interface HomeHeroRequest {
  one: string
  two: string
  three: string
  four: string
  five: string
}

export const useHomeHeroStore = defineStore('home-hero', () => {
  const posters = ref<HomeHeroRequest>()
  const ready = ref(false)

  function setPosters(data: string[]) {
    posters.value = {
      one: data[0],
      two: data[1],
      three: data[2],
      four: data[3],
      five: data[4],
    }
    ready.value = true
  }

  return {
    posters,
    ready,
    setPosters,
  }
})
