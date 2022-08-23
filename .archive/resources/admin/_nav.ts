import { __ } from 'matice'
import route from 'ziggy-js'
import {
  BookOpenIcon,
  CogIcon,
  CollectionIcon,
  HomeIcon,
  MailIcon,
  NewspaperIcon,
  PrinterIcon,
  TagIcon,
  TemplateIcon,
  TranslateIcon,
  UserIcon,
  UsersIcon,
} from '@heroicons/vue/outline'

interface NavTitle {
  title: string
}
interface NavLink {
  href: string
  active: () => boolean
  icon?: any
  text: string
  external?: boolean
}

const mainNav: (NavLink | NavTitle)[] = [
  {
    href: route('admin.dashboard'),
    active: () => route().current('admin.dashboard'),
    icon: HomeIcon,
    text: __('Dashboard'),
  },
  { title: __('Entities') },
  {
    href: route('admin.books'),
    active: () =>
      route().current('admin.books') || route().current('admin.books.*'),
    icon: BookOpenIcon,
    text: __('Books'),
  },
  {
    href: route('admin.series'),
    active: () =>
      route().current('admin.series') || route().current('admin.series.*'),
    icon: CollectionIcon,
    text: __('Series'),
  },
  {
    href: route('admin.authors'),
    active: () =>
      route().current('admin.authors') || route().current('admin.authors.*'),
    icon: UserIcon,
    text: __('Authors'),
  },
  {
    href: route('admin.tags'),
    active: () =>
      route().current('admin.tags') || route().current('admin.tags.*'),
    icon: TagIcon,
    text: __('Tags'),
  },
  {
    href: route('admin.languages'),
    active: () =>
      route().current('admin.languages')
      || route().current('admin.languages.*'),
    icon: TranslateIcon,
    text: __('Languages'),
  },
  {
    href: route('admin.publishers'),
    active: () =>
      route().current('admin.publishers')
      || route().current('admin.publishers.*'),
    icon: PrinterIcon,
    text: __('Publishers'),
  },
  { title: __('Posts') },
  {
    href: route('admin.posts'),
    active: () =>
      route().current('admin.posts') || route().current('admin.posts.*'),
    icon: NewspaperIcon,
    text: __('Posts'),
  },
  {
    href: route('admin.pages'),
    active: () =>
      route().current('admin.pages') || route().current('admin.pages.*'),
    icon: TemplateIcon,
    text: __('Pages'),
  },
  { title: __('Settings') },
  {
    href: route('admin.users'),
    active: () =>
      route().current('admin.users') || route().current('admin.users.*'),
    icon: UsersIcon,
    text: __('Users'),
  },
  {
    href: route('admin.submissions'),
    active: () =>
      route().current('admin.submissions')
      || route().current('admin.submissions.*'),
    icon: MailIcon,
    text: __('Submissions'),
  },
  {
    href: route('admin.settings'),
    active: () => route().current('admin.settings'),
    icon: CogIcon,
    text: __('Settings'),
  },
]

const isTitle = (a: NavTitle | NavLink): a is NavTitle => {
  return (a as NavTitle).title !== undefined
}
const isLink = (a: NavTitle | NavLink): a is NavLink => {
  return (a as NavLink).href !== undefined
}

export { NavLink, NavTitle, isTitle, isLink, mainNav }
