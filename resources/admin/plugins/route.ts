import { App } from 'vue'
import route from 'ziggy-js'

export default {
  install: (app: App): void => {
    app.config.globalProperties.route = route
  },
}

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    route: typeof route
  }
}
