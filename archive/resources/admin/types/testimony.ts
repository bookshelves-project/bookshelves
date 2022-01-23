import { Model } from './model'
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'

export class Testimony extends Model {
  constructor(
    public id: number,
    // public featured_image: MediaLibrary.MediaAttributes[],
    public title: string,
    public active: boolean,
    public summary: string,
    public rating: number,
    public youtube_video_id: string,
    public published_at: string,
    public universe: string,
    public created_at: string,
    public updated_at: string
  ) {
    super(id)
  }
  toString() {
    return this.title
  }
}
