import { defineStore } from 'pinia'

export const useElfinderStore = defineStore('elfinder', {
  state: () => ({
    elfinderStatus: false,
  }),
  actions: {
    toggleElfinderStatus() {
      this.$patch({
        elfinderStatus: !this.elfinderStatus,
      })
    },
  },
})
