import { useFetch } from '@kiwilan/typescriptable-laravel'

export function useDownload() {
  function downloadURI(uri: string, name: string) {
    const link = document.createElement('a')
    link.download = name
    link.href = uri
    link.click()
    link.remove()
  }

  async function execute(type: string, id: string | undefined) {
    if (!id) {
      return
    }

    const { laravel } = useFetch()
    await laravel.get('api.download.save', {
      type,
      id,
    })
  }

  async function save(model: App.Models.Book | App.Models.Serie, type: 'book' | 'serie') {
    if (type === 'book') {
      await saveBook(model as App.Models.Book)
    }
    else {
      await saveSerie(model as App.Models.Serie)
    }
  }

  async function saveBook(book: App.Models.Book) {
    await execute('book', book.id)

    downloadURI(book.nitro_stream_url!, `${book.title}`)
  }

  async function saveSerie(serie: App.Models.Serie) {
    await execute('serie', serie.id)

    downloadURI(serie.nitro_stream_url!, `${serie.title}`)
  }

  return {
    save,
  }
}
