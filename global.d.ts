/// <reference types="vite/client" />

import type { Axios } from 'axios'

declare global {
  interface Window {
    axios: Axios
    Alpine: Alpine
  }
}

window.axios = window.axios || {}
window.Alpine = window.Alpine || {}

export {}
