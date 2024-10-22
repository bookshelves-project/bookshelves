import type { Ebook } from '@/Types'
import { FoliateEngine } from './Foliate'
// import * as foliate from './Foliate/library/viewer'

export async function useFoliate(url: string | undefined) {
  const engine = await FoliateEngine.make(url)
  // const native = await foliate.makeBook(url)
  console.log(engine)
  console.log(engine.getSizeHuman())

  return {
    ebook: engine.getEbook(),
  }
}
