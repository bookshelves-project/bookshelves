import { defineStore } from 'pinia'
import {
  ClockIcon,
  CogIcon,
  CreditCardIcon,
  DocumentReportIcon,
  HomeIcon,
  QuestionMarkCircleIcon,
  ScaleIcon,
  ShieldCheckIcon,
  UserGroupIcon,
} from '@heroicons/vue/outline'

export const useIndexStore = defineStore({
  id: 'store',
  state: () => ({
    sidebar: false,
    navigation: [
      {
        name: 'Home',
        href: '#',
        icon: HomeIcon,
        current: true,
      },
      {
        name: 'History',
        href: '#',
        icon: ClockIcon,
        current: false,
      },
      {
        name: 'Balances',
        href: '#',
        icon: ScaleIcon,
        current: false,
      },
      {
        name: 'Cards',
        href: '#',
        icon: CreditCardIcon,
        current: false,
      },
      {
        name: 'Recipients',
        href: '#',
        icon: UserGroupIcon,
        current: false,
      },
      {
        name: 'Reports',
        href: '#',
        icon: DocumentReportIcon,
        current: false,
      },
    ],
    secondaryNavigation: [
      {
        name: 'Settings',
        href: '#',
        icon: CogIcon,
      },
      {
        name: 'Help',
        href: '#',
        icon: QuestionMarkCircleIcon,
      },
      {
        name: 'Privacy',
        href: '#',
        icon: ShieldCheckIcon,
      },
    ],
  }),
  actions: {
    toggleSidebar() {
      this.$patch({
        sidebar: !this.sidebar,
      })
    },
    closeSidebar() {
      this.$patch({
        sidebar: false,
      })
    },
  },
})
