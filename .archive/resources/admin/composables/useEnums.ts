import type { EnumTypes } from '@admin/types'
import { usePage } from '@inertiajs/inertia-vue3'

export const useEnums = () => {
  const getChartColors = () => {
    const options = usePage().props.value.enums as EnumTypes

    return options.chart_colors
  }

  return {
    getChartColors,
  }
}
