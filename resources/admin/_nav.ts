import { __ } from 'matice'
import route from 'ziggy-js'

interface NavTitle {
  title: string
}
interface NavLink {
  href: string
  active: () => boolean
  icon: string
  text: string
}

const mainNav: (NavLink | NavTitle)[] = [
  {
    href: route('admin.dashboard'),
    active: () => route().current('admin.dashboard'),
    icon: 'chart-bar',
    text: __('Dashboard'),
  },
  { title: __('Content Managment') },
  {
    href: route('admin.posts'),
    active: () =>
      route().current('admin.posts') || route().current('admin.posts.*'),
    icon: 'newspaper',
    text: __('Posts'),
  },
  { title: __('Access Managment') },
  {
    href: route('admin.users'),
    active: () =>
      route().current('admin.users') || route().current('admin.users.*'),
    icon: 'users',
    text: __('Users'),
  },
]

const isTitle = (a: NavTitle | NavLink): a is NavTitle => {
  return (a as NavTitle).title !== undefined
}
const isLink = (a: NavTitle | NavLink): a is NavLink => {
  return (a as NavLink).href !== undefined
}

export { NavLink, NavTitle, isTitle, isLink, mainNav }
