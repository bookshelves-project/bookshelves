import type { Alpine as AlpineType } from '@types/alpinejs'

interface Window {
  Alpine: AlpineType
}

declare module 'alpinejs'
