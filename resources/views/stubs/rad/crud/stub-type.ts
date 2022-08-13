// @ts-expect-error
import { Model } from './model'

export class Stub extends Model {
  constructor(public id: number, public stubAttr: string) {
    super(id)
  }

  toString() {
    return this.stubAttr
  }
}
