import { Model } from './model'

export class Language extends Model {
  constructor(public name: string, public slug: string) {
    super(slug)
  }

  toString() {
    return this.name
  }
}
