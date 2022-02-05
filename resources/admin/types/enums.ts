export interface EnumTypes {
  roles: { [key: string]: string }
  post_statuses: { [key: string]: string }
  tag_types: { [key: string]: string }
  book_types: { [key: string]: string }
}

export const enumVariants = {
  post_statuses: {
    draft: 'bg-red-500',
    scheduled: 'bg-yellow-500',
    published: 'bg-green-500',
  },
  tag_types: {
    tag: 'bg-gray-600',
    genre: 'bg-primary-500',
  },
  book_types: {
    handbook: 'bg-gray-600',
    essay: 'bg-blue-600',
    comic: 'bg-green-600',
    novel: 'bg-primary-600',
  },
}
