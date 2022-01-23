import { Model } from './model'

export class ResidenceProject extends Model {
  constructor(
    public id: number,
    public id_mdm: string,
    public id_grimmo: number,
    public code_maturity: number,
    public name: string,
    public city: string,
    public call_price: number,
    public remaining_lots: number,
    public delivery_date: string,
    public construction_start_date: string,
    public law: string
  ) {
    super(id)
  }
  toString() {
    return this.name
  }
}
