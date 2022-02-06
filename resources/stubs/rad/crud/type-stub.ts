// @ts-ignore
import { Model } from './model'

export class Stub extends Model {
  constructor(public id: number, public name: string) {
    super(id)
  }
  toString() {
    return this.name
  }
}
