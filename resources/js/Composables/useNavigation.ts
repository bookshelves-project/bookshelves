import { usePage } from '@inertiajs/vue3'
import { useRouter } from '@kiwilan/typescriptable-laravel'

export interface Link {
  label: string
  icon?: SvgName
  route?: App.Route.RouteConfig<App.Route.Name>
  url?: string
  isExternal?: boolean
  isSeperator?: boolean
  restrictedRoles?: string[]
  isLibrary?: boolean
  libraryUrl?: string
  librarySeriesUrl?: string
}

const mainLinks = ref<Link[]>([])

const profileLinks: Link[] = [
]

export function useNavigation() {
  const { props } = usePage()
  const { baseURL } = useRouter()

  const secondaryLinks: Link[] = [
    { label: 'Help', icon: 'info', route: { name: 'pages.help' } },
    { label: 'OPDS (books)', icon: 'opds', url: `${baseURL.value}/opds` },
    { label: 'Contact', icon: 'mail', route: { name: 'form.message' } },
  ]

  const libraries = props?.libraries as App.Models.Library[]

  if (libraries && mainLinks.value.length === 0) {
    mainLinks.value = [
      { label: 'Dashboard', icon: 'home', route: { name: 'home' } },
      { label: 'Authors', icon: 'quill', route: { name: 'authors.index' } },
      { label: 'Tags', icon: 'tag', route: { name: 'tags.index' } },
      { label: 'Seperator', isSeperator: true },
      { label: 'All libraries', icon: 'libraries', route: { name: 'libraries.index' } },
    ]

    libraries.forEach((library) => {
      mainLinks.value.push({
        label: library.name,
        icon: library.type as SvgName,
        route: { name: 'libraries.show', params: { library: library.slug } },
        isLibrary: true,
        libraryUrl: `/libraries/${library.slug}`,
        librarySeriesUrl: `/libraries/${library.slug}/series`,
      })
    })
  }

  return {
    mainLinks,
    secondaryLinks,
    profileLinks,
  }
}
