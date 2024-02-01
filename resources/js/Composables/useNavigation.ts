export interface Link {
  label: string
  icon?: SvgName
  route?: App.Route.RouteConfig<App.Route.Name>
  url?: string
  isExternal?: boolean
  isSeperator?: boolean
  restrictedRoles?: string[]
}

const mainLinks: Link[] = [
  { label: 'Dashboard', icon: 'home', route: { name: 'home' } },
  { label: 'Authors', icon: 'quill', route: { name: 'authors.index' } },
  { label: 'Seperator', isSeperator: true },
  { label: 'Audiobooks', icon: 'audible', route: { name: 'audiobooks.index' } },
  { label: 'Books', icon: 'ereader', route: { name: 'books.index' } },
  { label: 'Comics', icon: 'comic', route: { name: 'comics.index' } },
  { label: 'Mangas', icon: 'manga', route: { name: 'mangas.index' } },
  { label: 'Seperator', isSeperator: true },
  { label: 'Audiobook series', icon: 'audible', route: { name: 'series.audiobooks.index' } },
  { label: 'Book series', icon: 'ereader', route: { name: 'series.books.index' } },
  { label: 'Comic series', icon: 'comic', route: { name: 'series.comics.index' } },
  { label: 'Manga series', icon: 'manga', route: { name: 'series.mangas.index' } },
]

const secondaryLinks: Link[] = [
  { label: 'OPDS', icon: 'opds', route: { name: 'opds.index' }, isExternal: true },
  { label: 'Message', icon: 'mail', route: { name: 'form.message' } },
  { label: 'Help', icon: 'info', route: { name: 'pages.help' } },
]

const profileLinks: Link[] = [
]

export function useNavigation() {
  return {
    mainLinks,
    secondaryLinks,
    profileLinks,
  }
}
