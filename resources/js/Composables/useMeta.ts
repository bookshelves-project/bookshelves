import { usePage } from '@inertiajs/vue3'

export function useMeta() {
  const page = usePage()
  const ziggy: any = page.props.ziggy
  const baseURL = ziggy.url
  const currentUrl = ziggy.location

  function domainFromUrl(url: string) {
    const urlObject = new URL(url)
    return urlObject.hostname
  }

  function imageUrl(image?: string, defaultImage?: string): string {
    if (!image)
      return `${baseURL}${defaultImage}`

    if (image.startsWith('http'))
      return image
    else
      return `${baseURL}${image}`
  }

  function limit(text?: string, limit?: number): string {
    if (!text)
      return ''

    if (!limit) {
      return text
    }

    return text.length > limit ? `${text.substring(0, limit)}...` : text
  }

  function removeTags(string: string | undefined): string {
    if ((string === null) || (string === '') || (string === undefined))
      return ''
    else
      string = string.toString()

    return string.replace(/(<([^>]+)>)/g, '')
  }

  return {
    domainFromUrl,
    imageUrl,
    limit,
    removeTags,
    currentUrl,
  }
}
