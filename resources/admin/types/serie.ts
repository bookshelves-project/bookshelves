import { Model } from './model'

export class Serie extends Model {
  constructor(public id: number, public title: string) {
    super(id)
  }
  toString() {
    return this.title
  }
}
