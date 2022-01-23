import { usePage } from '@inertiajs/inertia-vue3'
import { __, TranslationOptions } from 'matice'
import { useTitle as vueUseTitle } from '@vueuse/core'
import { Model, Post, User } from '@admin/types'

export function useTitle(title: string, options?: TranslationOptions): string {
  const subTitle = __(title, options)
  vueUseTitle(`${subTitle} - ${usePage().props.value.appName}`)
  return subTitle
}

export function useUniqueId(): string {
  return Math.random().toString(36).substr(2, 9)
}

export function useModelToString(
  resource: string | undefined,
  model: Model | undefined
): string | undefined {
  if (resource) {
    return (
      {
        users: (model: User) => model.name,
        posts: (model: Post) => model.title,
      } as { [key: string]: (model) => string }
    )[resource](model)
  }
}
