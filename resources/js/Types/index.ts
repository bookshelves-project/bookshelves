export interface Entity {
  title?: string
  slug?: string
  type?: string
  authors?: App.Models.Author[]
  serie?: string
  language?: string
  volume?: string
  count?: string
  cover_thumbnail?: string
  cover_color?: string
  meta_route: string
}
