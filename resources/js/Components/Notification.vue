<script lang="ts" setup>
import type { NotificationExtended } from '@/Composables/useNotification'

const props = defineProps<{
  notification: NotificationExtended
}>()

const displayed = ref(false)

onMounted(() => {
  setTimeout(() => {
    displayed.value = true
    const timeout = (props.notification.timeout || 5000) - 500

    setTimeout(() => {
      displayed.value = false
    }, timeout)
  }, 150)
})
</script>

<template>
  <div
    class="notification"
    :class="displayed ? 'notification-opened' : 'notification-closed'"
  >
    <div class="notification-container">
      <div class="notification-container_wrapper">
        <div class="notification-container_wrapper-logo">
          <svg
            class="notification-container_wrapper-logo-svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
        </div>
        <div class="notification-container_wrapper-text">
          <p class="notification-container_wrapper-text-title">
            {{ notification.title }}
          </p>
          <p
            v-if="notification.description"
            class="notification-container_wrapper-text-description"
          >
            {{ notification.description }}
          </p>
        </div>
        <div class="notification-container_wrapper-close">
          <button
            type="button"
            class="notification-container_wrapper-close-button"
          >
            <span class="notification-sr">Close</span>
            <svg
              class="notification-container_wrapper-close-button-svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="css" scoped>
.notification {
  @apply pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1 ring-opacity-5;
  @apply bg-white ring-black;
  @apply transform ease-out duration-300 transition;
}
.notification-opened {
  @apply translate-y-0 opacity-100 sm:translate-x-0;
}
.notification-closed {
  @apply translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2;
}

.notification-container {
  @apply p-4;
}
.notification-container_wrapper {
  @apply flex items-start;
}
.notification-container_wrapper-logo {
  @apply flex-shrink-0;
}
.notification-container_wrapper-logo-svg {
  @apply h-6 w-6;
  @apply text-green-400;
}
.notification-container_wrapper-text {
  @apply ml-3 w-0 flex-1 pt-0.5;
}
.notification-container_wrapper-text-title {
  @apply text-sm font-medium;
  @apply text-gray-900;
}
.notification-container_wrapper-text-description {
  @apply mt-1 text-sm;
  @apply text-gray-500;
}

.notification-container_wrapper-close {
  @apply ml-4 flex flex-shrink-0;
}
.notification-container_wrapper-close-button {
  @apply inline-flex rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2;
  @apply bg-white text-gray-400 hover:text-gray-500 focus:ring-indigo-500;
}
.notification-sr {
  @apply sr-only;
}
.notification-container_wrapper-close-button-svg {
  @apply h-5 w-5;
}
</style>
