<script lang="ts" setup>
import { useNotification } from '@/Composables/useNotification'

const { notifications } = useNotification()
</script>

<template>
  <!-- Global notification live region, render this permanently at the end of the document -->
  <div
    aria-live="assertive"
    class="notifications-container"
  >
    <div class="notifications-container_wrapper">
      <!--
      Notification panel, dynamically insert this into the live region when it needs to be displayed

      Entering: "transform ease-out duration-300 transition"
        From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        To: "translate-y-0 opacity-100 sm:translate-x-0"
      Leaving: "transition ease-in duration-100"
        From: "opacity-100"
        To: "opacity-0"
    -->
      <template v-if="notifications.length">
        <Notification
          v-for="notification in notifications"
          :key="notification.id"
          :notification="notification"
        />
      </template>
    </div>
  </div>
</template>

<style lang="css" scoped>
.notifications-container {
  @apply pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6;
  z-index: 9999;
}

.notifications-container_wrapper {
  @apply flex w-full flex-col items-center space-y-4 sm:items-end;
}
</style>
