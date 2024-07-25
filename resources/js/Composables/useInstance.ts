export function useInstance() {
  function toBooks(books: any) {
    return books as App.Models.Book[]
  }

  function toAuthors(authors: any) {
    return authors as App.Models.Author[]
  }

  function toSeries(series: any) {
    return series as App.Models.Serie[]
  }

  function toAny(models: any) {
    return models as any
  }

  return {
    toBooks,
    toAuthors,
    toSeries,
    toAny,
  }
}
