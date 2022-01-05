import { usePage } from '@inertiajs/inertia-vue3'
import { __, TranslationOptions } from 'matice'
import { useTitle as vueUseTitle } from '@vueuse/core'
import {
  Model,
  Page,
  Post,
  User,
  Testimony,
  Service,
  PageResidence,
  ResidenceLot,
  Animation,
  Residence,
  ResidenceProject,
  PageResidenceProject,
  FaqCategory,
  FaqQuestion,
} from '@admin/types'
import { PageTemplate } from '@admin/types/page'

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
        pages: (model: Page<PageTemplate>) => model.title,
        blocks: (model: Page<PageTemplate>) => model.title,
        testimonies: (model: Testimony) => model.title,
        services: (model: Service) => model.title,
        'page-residences': (model: PageResidence) => model.residence.name,
        animations: (model: Animation) => model.title,
        'residence-lots': (model: ResidenceLot) => model.housing_type,
        residences: (model: Residence) => model.name,
        'residence-projects': (model: ResidenceProject) => model.name,
        'page-residence-projects': (model: PageResidenceProject) =>
          model.project.name,
        'faq-categories': (model: FaqCategory) => model.name,
        'faq-questions': (model: FaqQuestion) => model.title,
      } as { [key: string]: (model) => string }
    )[resource](model)
  }
}
