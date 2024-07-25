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

  return {
    toBooks,
    toAuthors,
    toSeries,
  }
}
