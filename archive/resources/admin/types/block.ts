// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'
import { Page, PageTemplate } from './page'
import { Post } from './post'
import { PageResidence } from './page-residence'
export interface Block {
  id: number
  title: string
  section: 'header' | 'footer'
  // featured_image: MediaLibrary.MediaAttributes[]
  content_position: 'left' | 'center' | 'right'
  content: string
  active: boolean
  cta_text: string
  cta_link: string
  system_urls: string
  pages: Page<PageTemplate>[]
  posts: Post[]
  page_residences: PageResidence[]
}
