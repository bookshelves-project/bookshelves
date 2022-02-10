// @ts-ignore
import { Model } from './model'

export class WikipediaItem extends Model {
  constructor(public id: number, public search_query: string) {
    super(id)
  }
  toString() {
    return this.search_query
  }
}
