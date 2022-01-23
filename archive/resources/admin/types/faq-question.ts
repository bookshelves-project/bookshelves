import { Model } from './model'
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'

export class FaqQuestion extends Model {
  constructor(
    public id: number,
    public title: string,
    public faq_category_id: number,
    public slug: string,
    public summary: string,
    public body: string // public featured_image: MediaLibrary.MediaAttributes[]
  ) {
    super(id)
  }
  toString() {
    return this.title
  }
}
