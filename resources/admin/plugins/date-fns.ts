import { App } from 'vue'

import { format as dateFormat, parseJSON as dateParse } from 'date-fns'

export default {
  install: (app: App): void => {
    app.config.globalProperties.$dateFormat = (
      date: string | number | undefined,
      format = 'dd/MM/yyyy'
    ): string => (date ? dateFormat(dateParse(date), format) : '')
  },
}

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $dateFormat: (date: string | number | undefined, format: string) => string
  }
}
