export interface Link {
  label: string
  icon?: SvgName
  route?: App.Route.RouteConfig<App.Route.Name>
  url?: string
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
  // { label: 'Help', icon: 'info', route: { name: 'pages.help' } },
  // { label: 'Ask Movie/TV show', icon: 'question-mark', route: { name: 'form.demand' } },
  // { label: 'Bug report', icon: 'bug', route: { name: 'form.message' } },
]

const profileLinks: Link[] = [
  // { label: 'Profile', icon: 'user', route: { name: 'profile.show' } },
  // { label: 'Pulse', icon: 'pulse', url: '/pulse', restrictedRoles: ['super_admin'] },
  // { label: 'Logs', icon: 'log', url: '/log-viewer', restrictedRoles: ['super_admin'] },
  // { label: 'Admin', icon: 'lock', url: '/admin', restrictedRoles: ['super_admin'] },
]

export function useNavigation() {
  return {
    mainLinks,
    secondaryLinks,
    profileLinks,
  }
}
