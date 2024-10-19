import type { Ebook } from '@/Types'
import { getBook } from './Foliate'
import * as foliate from './Foliate/library/viewer'

export async function useFoliate(url: string | undefined) {
  const ebook = ref<Ebook>()
  await getBook(url)
  const native = await foliate.makeBook(url)
  console.log(native)

  return {
    ebook,
  }
}
