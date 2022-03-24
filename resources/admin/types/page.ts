// @ts-ignore
import { Model } from './model'

export class Page extends Model {
  constructor(public id: number, public title: string) {
    super(id)
  }
  toString() {
    return this.title
  }
}
