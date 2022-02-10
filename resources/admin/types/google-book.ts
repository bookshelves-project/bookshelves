// @ts-ignore
import { Model } from './model'

export class GoogleBook extends Model {
  constructor(public id: number, public original_isbn: string) {
    super(id)
  }
  toString() {
    return this.original_isbn
  }
}
