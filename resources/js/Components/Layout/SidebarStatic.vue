<script lang="ts" setup>
import { useInertia } from '@kiwilan/typescriptable-laravel'
import { useNavigation } from '@/Composables/useNavigation'

const { mainLinks, secondaryLinks } = useNavigation()
</script>

<template>
  <div class="hidden xl:fixed xl:inset-y-0 xl:z-50 xl:flex xl:w-72 xl:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-black/10 px-6 ring-1 ring-white/5">
      <ILink
        class="flex h-16 shrink-0 items-center space-x-2"
        href="/"
      >
        <Logo class="h-8 w-auto" />
        <div class="relative">
          <SvgIcon
            name="logo-text"
            class="h-7 w-auto"
          />
        </div>
      </ILink>
      <nav class="flex flex-1 flex-col">
        <ul
          class="flex flex-1 flex-col gap-y-7"
          role="list"
        >
          <li>
            <ul
              class="-mx-2 space-y-1"
              role="list"
            >
              <!-- <LayoutSidebarLink
                v-for="link in mainLinks"
                :key="link.label"
                :link="link"
              /> -->
            </ul>
          </li>
          <li class="mb-5 mt-auto">
            <ul
              class="-mx-2 space-y-1"
              role="list"
            >
              <!-- <LayoutSidebarLink
                v-for="link in secondaryLinks"
                :key="link.label"
                :link="link"
              /> -->
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>
