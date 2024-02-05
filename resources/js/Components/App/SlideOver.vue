<script lang="ts" setup>
import { onClickOutside } from '@vueuse/core'
import { useSlideover } from '@kiwilan/typescriptable-laravel'

defineProps<{
  title?: string
}>()

const { layer, isOpen, close } = useSlideover()

const target = ref<HTMLElement>()
onClickOutside(target, () => close())
</script>

<template>
  <div
    v-cloak
    class="relative z-10"
    :aria-labelledby="`slide-over-${title}`"
    role="dialog"
    aria-modal="true"
  >
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div
      v-if="layer"
      class="fixed inset-0"
    />

    <div
      v-if="layer"
      class="fixed inset-0 overflow-hidden"
    >
      <div class="absolute inset-0 overflow-hidden">
        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
          <!--
          Slide-over panel, show/hide based on slide-over state.

          Entering: "transform transition ease-in-out duration-500 sm:duration-700"
            From: "translate-x-full"
            To: "translate-x-0"
          Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
            From: "translate-x-0"
            To: "translate-x-full"
        -->
          <div
            ref="target"
            :class="isOpen ? 'translate-x-0' : 'translate-x-full'"
            class="pointer-events-auto w-screen max-w-sm transform transition ease-in-out duration-500 sm:duration-700"
          >
            <div class="flex h-full flex-col overflow-y-scroll bg-gray-800 py-6 shadow-xl">
              <div class="px-4 sm:px-6">
                <div class="flex items-start justify-between">
                  <h2
                    id="slide-over-title"
                    class="text-base font-semibold leading-6 text-gray-100"
                  >
                    {{ title }}
                  </h2>
                  <div class="ml-3 flex h-7 items-center">
                    <button
                      type="button"
                      class="relative rounded-md bg-gray-700 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                      @click="close()"
                    >
                      <span class="absolute -inset-2.5" />
                      <span class="sr-only">Close panel</span>
                      <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        aria-hidden="true"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="relative mt-6 flex-1 px-4 sm:px-6">
                <slot />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
