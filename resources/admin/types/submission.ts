import { Model } from './model'

export class Submission extends Model {
  constructor(
    public id: number,
    public name: string,
    public email: string,
    public message: string,
  ) {
    super(id)
  }

  toString() {
    return this.name
  }
}
