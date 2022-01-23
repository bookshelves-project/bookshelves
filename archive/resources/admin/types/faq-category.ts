import { Model } from './model'

export class FaqCategory extends Model {
  constructor(
    public id: number,
    public name: string,
    public slug: string,
    public created_at: string,
    public updated_at: string
  ) {
    super(id)
  }
  toString() {
    return this.name
  }
}
