import { Residence } from './residence'
import { Model } from './model'

export class Animation extends Model {
  constructor(
    public id: number,
    public id_mdm: string,
    public residence: Residence,
    public title: string,
    public text: string,
    public icon: string,
    public start_date: string,
    public created_at: string,
    public updated_at: string
  ) {
    super(id)
  }
  toString() {
    return this.title
  }
}
