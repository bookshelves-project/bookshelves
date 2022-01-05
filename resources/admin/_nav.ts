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
  { title: 'Métier' },
  {
    href: route('admin.residences'),
    active: () =>
      route().current('admin.residences') ||
      route().current('admin.residences.*'),
    icon: 'office-building',
    text: __('Residences'),
  },
  {
    href: route('admin.page-residences'),
    active: () =>
      route().current('admin.page-residences') ||
      route().current('admin.page-residences.*'),
    icon: 'office-building',
    text: __('Pages Residence'),
  },
  {
    href: route('admin.residence-lots'),
    active: () =>
      route().current('admin.residence-lots') ||
      route().current('admin.residence-lots.*'),
    icon: 'clipboard-list',
    text: __('Lots disponibles'),
  },
  {
    href: route('admin.animations'),
    active: () =>
      route().current('admin.animations') ||
      route().current('admin.animations.*'),
    icon: 'cake',
    text: __('Animations'),
  },
  {
    href: route('admin.services'),
    active: () =>
      route().current('admin.services') || route().current('admin.services.*'),
    icon: 'briefcase',
    text: __('Services'),
  },
  {
    href: route('admin.residence-projects'),
    active: () =>
      route().current('admin.residence-projects') ||
      route().current('admin.residence-projects.*'),
    icon: 'office-building',
    text: __('Projects'),
  },
  {
    href: route('admin.page-residence-projects'),
    active: () =>
      route().current('admin.page-residence-projects') ||
      route().current('admin.page-residence-projects.*'),
    icon: 'office-building',
    text: __('Pages Project'),
  },
  { title: __('Content Managment') },
  {
    href: route('admin.pages'),
    active: () =>
      route().current('admin.pages') || route().current('admin.pages.*'),
    icon: 'document-text',
    text: __('Pages'),
  },
  {
    href: route('admin.posts'),
    active: () =>
      route().current('admin.posts') || route().current('admin.posts.*'),
    icon: 'newspaper',
    text: __('Posts'),
  },
  {
    href: route('admin.blocks'),
    active: () =>
      route().current('admin.blocks') || route().current('admin.blocks.*'),
    icon: 'view-grid',
    text: __('Blocks'),
  },
  {
    href: route('admin.testimonies'),
    active: () =>
      route().current('admin.testimonies') ||
      route().current('admin.testimonies.*'),
    icon: 'video-camera',
    text: __('Testimonies'),
  },
  {
    href: route('admin.faq-categories'),
    active: () =>
      route().current('admin.faq-categories') ||
      route().current('admin.faq-categories.*'),
    icon: 'tag',
    text: __('FAQ - Categories'),
  },
  {
    href: route('admin.faq-questions'),
    active: () =>
      route().current('admin.faq-questions') ||
      route().current('admin.faq-questions.*'),
    icon: 'newspaper',
    text: __('FAQ - Questions'),
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
