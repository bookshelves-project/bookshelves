import type { Alpine as AlpineType } from 'alpinejs'

/**
 * From https://bobbyhadz.com/blog/typescript-make-types-global
 */
declare global {
  interface Window {
    Alpine: AlpineType
  }
}

export { }