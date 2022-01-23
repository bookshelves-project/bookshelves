import { Model } from './model'

export class Residence extends Model {
  constructor(
    public id: number,
    public id_mdm: string,
    public id_grimmo: number,
    public id_sci: string,
    public id_dwh: number,
    public status: string,
    public name: string,
    public city: string,
    public call_price: number,
    public remaining_lots: number
  ) {
    super(id)
  }
  toString() {
    return this.name
  }
}
