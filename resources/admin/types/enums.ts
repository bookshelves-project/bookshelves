export interface EnumTypes {
  roles: { [key: string]: string }
  post_statuses: { [key: string]: string }
  tag_types: { [key: string]: string }
  book_types: { [key: string]: string }
  author_roles: { [key: string]: string }
  chart_colors: { [key: string]: string }
}

export const enumVariants = {
  post_statuses: {
    draft: 'bg-red-100',
    scheduled: 'bg-yellow-100',
    published: 'bg-green-100',
  },
  tag_types: {
    tag: 'bg-gray-100',
    genre: 'bg-primary-100',
  },
  book_types: {
    handbook: 'bg-gray-100',
    essay: 'bg-blue-100',
    comic: 'bg-green-100',
    novel: 'bg-primary-100',
  },
  author_roles: {
    aut: 'bg-primary-100',
  },
}
