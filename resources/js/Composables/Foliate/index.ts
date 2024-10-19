import { FoliateEngine } from './FoliateEngine'

export async function getBook(url: string | undefined) {
  if (!url) {
    console.error('URL is not defined')
  }

  const type = await FoliateEngine.make(url)

  // return {
  //   makeBook,
  // }
}
