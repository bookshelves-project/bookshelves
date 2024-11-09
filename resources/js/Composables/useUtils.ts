import { usePage } from '@inertiajs/vue3'
import { useFetch } from '@kiwilan/typescriptable-laravel'

export function useUtils() {
  /**
   * Transform bytes to human readable format.
   */
  function bytesToHuman(bytes?: number): string {
    if (!bytes)
      return 'N/A'

    const units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB']

    let i = 0
    for (; bytes > 1024; i++)
      bytes /= 1024

    return `${bytes.toFixed(2)} ${units[i]}`
  }

  function ucfirst(string?: string) {
    if (!string)
      return ''

    const lowercased = string.toLowerCase()
    return lowercased.charAt(0).toUpperCase() + lowercased.slice(1)
  }

  async function getSize(type: 'book' | 'serie', param: string): Promise<{ size: number, extension: string } | undefined> {
    const { laravel } = useFetch()
    const route = type === 'book' ? 'api.sizes.book' : 'api.sizes.serie' as any
    const name = type === 'book' ? 'book' : 'serie'

    const response = await laravel.get(route, { [name]: param })
    const body = await response.getBody<{
      size: number
      extension: string
    }>()

    return body
  }

  const useNitro = computed(() => {
    const { props } = usePage()

    return props.use_nitro ?? false
  })

  return {
    bytesToHuman,
    ucfirst,
    getSize,
    useNitro,
  }
}
