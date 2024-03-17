/// <reference types="vite/client" />

import type { Axios } from 'axios'

declare global {
  interface Window {
    axios: Axios
  }
}

window.axios = window.axios || {}

export {}
