import { Model } from './model'
import { Tag } from './tag'
import { User } from './user'

export class Book extends Model {
  constructor(
    public id: number,
    public featured_image: { preview_url: string; original_url: string }[],
    public category_id: number,
    public user_id: number,
    public title: string,
    public status: string,
    public summary: string,
    public body: string,
    public published_at: string,
    public pin: boolean,
    public promote: boolean,
    public slug: string,
    public meta_title: string,
    public meta_description: string,
    public created_at: string,
    public updated_at: string,
    public user: User,
    public tags: Tag[]
  ) {
    super(id)
  }
  toString() {
    return this.title
  }
}
