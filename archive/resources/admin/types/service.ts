import { Model } from './model'

export class Service extends Model {
  constructor(
    public id: number,
    public title: string,
    public text: string,
    public created_at: string,
    public updated_at: string
  ) {
    super(id)
  }
  toString() {
    return this.title
  }
}
