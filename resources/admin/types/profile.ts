import { Model } from './model'

export class Profile extends Model {
  constructor(
    public id: number,
    public name: string,
    public email: string,
    public is_impersonating: boolean
  ) {
    super(id)
  }
  toString() {
    return this.name
  }
}
