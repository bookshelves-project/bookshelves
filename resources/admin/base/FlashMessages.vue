<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <!-- Global notification live region, render this permanently at the end of the document -->
  <div
    aria-live="assertive"
    class="fixed z-50 inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start"
  >
    <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
      <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
      <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="show && message"
          class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
        >
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <component
                  :is="`${icon}-icon`"
                  class="h-6 w-6"
                  :class="{
                    'text-green-600': style == 'success',
                    'text-yellow-600': style == 'warning',
                    'text-red-600': style == 'danger',
                  }"
                />
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900 status">
                  {{ style }}
                </p>
                <p class="mt-1 text-sm text-gray-500">
                  {{ message }}
                </p>
              </div>
              <div class="ml-4 flex-shrink-0 flex">
                <button
                  class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  @click="show = false"
                >
                  <span class="sr-only">Close</span>
                  <XIcon class="h-5 w-5" aria-hidden="true" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { XIcon } from '@heroicons/vue/solid'
  import { computed, ref, watch } from 'vue'
  import { usePage } from '@inertiajs/inertia-vue3'

  const flash = computed(() => {
    return usePage().props.value.flash
  })

  const style = computed(() => {
    return flash.value?.danger
      ? 'danger'
      : flash.value?.warning
      ? 'warning'
      : 'success'
  })

  const icon = computed(() => {
    const v: 'success' | 'warning' | 'danger' = style.value

    return {
      success: 'check-circle',
      warning: 'exclamation',
      danger: 'x-circle',
    }[v]
  })

  const message = computed(() => {
    return flash.value[style.value]
  })

  watch(
    () => usePage().props.value.flash,
    () => {
      show.value = true
      setTimeout(() => {
        show.value = false
      }, 2500)
    }
  )
  const show = ref(true)
</script>

<style lang="css" scoped>
  .status::first-letter {
    text-transform: capitalize;
  }
</style>
