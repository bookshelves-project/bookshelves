export interface EnumTypes {
  roles: { [key: string]: string }
  post_statuses: { [key: string]: string }
}

export const enumVariants = {
  post_statuses: {
    draft: 'bg-red-500',
    scheduled: 'bg-yellow-500',
    published: 'bg-green-500',
  },
}
