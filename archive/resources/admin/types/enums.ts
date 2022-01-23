export interface EnumTypes {
  roles: { [key: string]: string }
  post_statuses: { [key: string]: string }
  universes: { [key: string]: string }
  positions: { [key: string]: string }
  icons: { [key: string]: string }
  outlined_icons: { [key: string]: string }
  page_templates: { [key: string]: string }
  block_sections: { [key: string]: string }
  residence_statuses: { [key: string]: string }
  apartment_types: { [key: string]: string }
}

export const enumVariants = {
  post_statuses: {
    draft: 'bg-red-500',
    scheduled: 'bg-yellow-500',
    published: 'bg-green-500',
  },
  universes: {
    vivre: 'bg-orange-500',
    investir: 'bg-blue-500',
  },
  residence_statuses: {
    completed: 'bg-green-500',
    development: 'bg-orange-500',
    pending: 'bg-yellow-500',
    construction: 'bg-red-500',
  },
}
