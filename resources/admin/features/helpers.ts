import { usePage } from '@inertiajs/inertia-vue3'
import { __, TranslationOptions } from 'matice'
import { useTitle as vueUseTitle } from '@vueuse/core'
import {
  Author,
  Book,
  Language,
  Model,
  Post,
  Publisher,
  Serie,
  Submission,
  Tag,
  User,
} from '@admin/types'

export function useTitle(title: string, options?: TranslationOptions): string {
  const subTitle = __(title, options)
  vueUseTitle(`${subTitle} - ${usePage().props.value.appName}`)
  return subTitle
}

export function getAppName(): string {
  return usePage().props.value.appName
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
        books: (model: Book) => model.title,
        series: (model: Serie) => model.title,
        authors: (model: Author) => model.name,
        submissions: (model: Submission) => model.name,
        tags: (model: Tag) => model.name,
        languages: (model: Language) => model.name,
        publishers: (model: Publisher) => model.name,
      } as { [key: string]: (model) => string }
    )[toCamelCase(resource)](model)
  }
}

const clearAndUpper = (resource: string) => {
  return resource.replace(/-/, '').toUpperCase()
}

const toCamelCase = (resource: string) => {
  return resource.replace(/-\w/g, clearAndUpper)
}
