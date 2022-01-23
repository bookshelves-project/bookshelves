import { Model } from './model'

export class User extends Model {
  constructor(
    public id: number,
    public name: string,
    public email: string,
    public active: boolean,
    public role: string,
    public last_login_at: string,
    public created_at: string,
    public updated_at: string,
    public can_be_updated: boolean,
    public can_be_impersonated: boolean
  ) {
    super(id)
  }
  toString() {
    return this.name
  }
}
