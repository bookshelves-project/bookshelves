<script lang="ts" setup>
import { onClickOutside } from '@vueuse/core'
import { useSidebar } from '@kiwilan/typescriptable-laravel'
import { useNavigation } from '@/Composables/useNavigation'

const { overlay, layer, isOpen, close } = useSidebar()

const target = ref<HTMLElement>()
onClickOutside(target, () => close())

function changePage() {
  close()
}

const { mainLinks, secondaryLinks } = useNavigation()
</script>

<template>
  <div
    v-cloak
    class="relative z-50 xl:hidden"
    role="dialog"
    aria-modal="true"
  >
    <!-- Off-canvas menu backdrop, show/hide based on off-canvas menu state. -->
    <div
      v-if="layer"
      class="fixed inset-0 bg-gray-900/80 transition-opacity duration-300 ease-linear"
      :class="overlay ? 'opacity-100' : 'opacity-0'"
    />

    <div
      v-if="layer"
      class="fixed inset-0 flex"
    >
      <!-- Off-canvas menu, show/hide based on off-canvas menu state. -->
      <div
        ref="target"
        class="relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300 ease-in-out"
        :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
      >
        <!-- Close button, show/hide based on off-canvas menu state. -->
        <div
          class="absolute left-full top-0 flex w-16 justify-center pt-5 duration-300 ease-in-out"
          :class="isOpen ? 'opacity-100' : 'opacity-0'"
        >
          <button
            class="-m-2.5 p-2.5"
            type="button"
            @click="close()"
          >
            <span class="sr-only">Close sidebar</span>
            <svg
              class="h-6 w-6 text-white"
              aria-hidden="true"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 ring-1 ring-white/10">
          <ILink
            class="flex h-16 shrink-0 items-center space-x-2 relative"
            href="/"
          >
            <Logo class="h-9 w-auto" />
            <div class="relative">
              <SvgIcon
                name="logo-text"
                class="h-7 w-auto"
              />
            </div>
            <EventFlag />
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
                  <LayoutSidebarLink
                    v-for="link in mainLinks"
                    :key="link.label"
                    :link="link"
                    @click="changePage"
                  />
                </ul>
              </li>
              <li class="mb-5 mt-auto">
                <ul
                  class="-mx-2 space-y-1"
                  role="list"
                >
                  <LayoutSidebarLink
                    v-for="link in secondaryLinks"
                    :key="link.label"
                    :link="link"
                    @click="changePage"
                  />
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>
