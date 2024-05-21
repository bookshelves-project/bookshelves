export interface Entity {
  title?: string
  slug?: string
  library?: App.Models.Library
  class: string
  authors?: App.Models.Author[]
  serie?: App.Models.Serie
  language?: App.Models.Language
  volume?: string
  count?: number
  cover_thumbnail?: string
  cover_color?: string
  route: string
}

export interface SearchEntity {
  query: string
  limit?: number
  count: number
  data: Entity[]
}
