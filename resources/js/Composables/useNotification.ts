export interface Notification {
  type?: 'success' | 'error' | 'info' | 'warning'
  title: string
  description?: string
}

export interface NotificationExtended extends Notification {
  id: number
  timeout: number
  timer: number
}

const notifications = ref<NotificationExtended[]>([])

export function useNotification(timeout = 5000) {
  // watch(notifications, (value) => {
  //   console.log(value)
  // })

  function push(notification: Notification) {
    if (!notification.type)
      notification.type = 'info'

    const n = {
      ...notification,
      id: Date.now(),
      timeout,
      timer: 0,
    }

    notifications.value.unshift(n)

    setTimeout(() => {
      notifications.value = notifications.value.filter(item => item.id !== n.id)
    }, n.timeout)
  }

  return {
    notifications,
    push,
  }
}
