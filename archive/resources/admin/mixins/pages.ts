import { useModelToString, useTitle } from '@admin/features/helpers'
import { Model } from '@admin/types'
import { transChoice } from 'matice'
import { computed, ExtractPropTypes, PropType, provide } from 'vue'

export const pageProps = {
  title: String,
  resource: {
    type: String,
    required: true,
    default: '',
  },
}

export const pageWithItemProps = {
  ...pageProps,
  item: {
    type: Object as PropType<Model>,
    required: true,
  },
}

export const pageSetup = (
  props: Readonly<ExtractPropTypes<typeof pageProps>>,
  name: string,
  count: number,
  args: { [key: string]: any } = {}
) => {
  const getTitle = computed(() => {
    return (
      props.title ||
      useTitle(`admin.titles.${name}`, {
        args: {
          resource: transChoice(
            `crud.${props.resource}.name`,
            count
          ).toLowerCase(),
          ...args,
        },
      })
    )
  })

  provide('resource', props.resource)

  return { getTitle }
}

export const pageWithItemSetup = (
  props: Readonly<ExtractPropTypes<typeof pageWithItemProps>>,
  name: string,
  count: number
) => {
  const initial = pageSetup(props, name, count, {
    label: useModelToString(props.resource, props.item),
    id: props.item?.id,
  })

  provide('item', props.item)

  return { ...initial }
}
