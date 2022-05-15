import { computed, ref } from 'vue'

export const useColorMode = () => {
  const isDarkMode = ref(false)
  setTimeout(() => {
    isDarkMode.value = document.documentElement.classList.contains('dark')
  }, 300)

  return {
    isDarkMode,
  }
}
