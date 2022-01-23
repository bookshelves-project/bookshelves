import { Model } from './model'

export class Tag extends Model {
  constructor(public id: number, public name: string, public slug: string) {
    super(id)
  }
  toString() {
    return this.name
  }
}
