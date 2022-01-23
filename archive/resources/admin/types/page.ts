import { Model } from './model'
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'

export class Page<T extends PageTemplate> extends Model {
  constructor(
    public id: number,
    public title: string,
    public active: boolean,
    public universe: 'vivre' | 'investir' = 'vivre',
    public body: string,
    public template: T,
    public slug: string,
    public meta_title: string,
    public meta_description: string,
    public created_at: string,
    public updated_at: string
  ) {
    super(id)
  }
  toString() {
    return this.title
  }
}

export interface PageTemplate {
  type: string
}

export class PageTemplate01 implements PageTemplate {
  type = 'template01'
  slides_title = ''
  slides_summary = ''
  slides: PageTemplate01Slide[] = []
  // video_image: MediaLibrary.MediaAttributes[] = []
  youtube_video_id = ''
  residences_search_block = false
  testimonies_block = false
  posts_block = false
}

export class PageTemplate01Slide {
  id: null | number = null
  title = ''
  icon = ''
  content = ''
}

export class PageTemplate02 implements PageTemplate {
  type = 'template02'
  assets: PageTemplate02Asset[] = []
  residence_projects_block = false
  testimonies_block = false
  posts_block = false
}

export class PageTemplate02Asset {
  icon = ''
  text = ''
}
