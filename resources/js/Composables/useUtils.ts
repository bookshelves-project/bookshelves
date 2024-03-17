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
    return string.charAt(0).toUpperCase() + string.slice(1)
  }

  async function getSize(type: 'book' | 'serie', param: string): Promise<{ size: number, extension: string }> {
    const { laravel } = useFetch()
    const route = type === 'book' ? 'api.sizes.book' : 'api.sizes.serie' as any
    const name = type === 'book' ? 'book' : 'serie'

    const response = await laravel.get(route, { [name]: param })
    return await response.json()
  }

  return {
    bytesToHuman,
    ucfirst,
    getSize,
  }
}
