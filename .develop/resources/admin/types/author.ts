import { Model } from './model'

export class Author extends Model {
  constructor(
    public id: number,
    public firstname: string,
    public lastname: string,
    public name: string,
  ) {
    super(id)
  }

  toString() {
    return `${this.firstname} ${this.lastname}`
  }
}
