import { Model } from './model'

export class ResidenceLot extends Model {
  constructor(
    public id: number,
    public id_mdm: string,
    public housing_type: string,
    public date_in: string,
    public date_out: string,
    public base_price: number,
    public additional_person_price: number,
    public old_person_option_price: number,
    public created_at: string,
    public updated_at: string
  ) {
    super(id)
  }
  toString() {
    return this.housing_type
  }
}
