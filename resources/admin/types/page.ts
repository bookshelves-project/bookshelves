// @ts-expect-error
import { Model } from './model'

export class Page extends Model {
  constructor(
    public id: number,
    public title: string,
    public featured_image: { preview_url: string; original_url: string }[],
  ) {
    super(id)
  }

  toString() {
    return this.title
  }
}
