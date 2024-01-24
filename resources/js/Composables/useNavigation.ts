export interface Link {
  label: string
  icon: SvgName
  route?: App.Route.RouteConfig<App.Route.Name>
  url?: string
  restrictedRoles?: string[]
}

const mainLinks: Link[] = [
  { label: 'Dashboard', icon: 'home', route: { name: 'home' } },
  // { label: 'Dropzone', icon: 'dropzone', route: { name: 'dropzone' } },
  { label: 'Audiobooks', icon: 'audible', route: { name: 'audiobooks.index' } },
  { label: 'Books', icon: 'ereader', route: { name: 'books.index' } },
  { label: 'Comics', icon: 'comic', route: { name: 'comics.index' } },
  { label: 'Mangas', icon: 'manga', route: { name: 'mangas.index' } },
  { label: 'Authors', icon: 'quill', route: { name: 'authors.index' } },
  // { label: 'Animation', icon: 'movie', route: { name: 'movies.animation' } },
  // { label: 'TV shows', icon: 'tv', route: { name: 'tv-shows.index' } },
  // { label: 'TV shows (Animation)', icon: 'tv', route: { name: 'tv-shows.animation' } },
  // { label: 'Movie collections', icon: 'stack', route: { name: 'collections.index' } },
  // { label: 'Documentaries', icon: 'movie', route: { name: 'movies.documentaries' } },
  // { label: 'Shows', icon: 'movie', route: { name: 'movies.shows' } },
  // { label: 'Genres', icon: 'tag', route: { name: 'genres.index' } },
  // { label: 'Networks', icon: 'network', route: { name: 'networks.index' } },
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
