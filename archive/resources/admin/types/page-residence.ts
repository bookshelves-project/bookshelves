import { Model } from './model'
import { Address } from './address'
import { Residence } from './residence'
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'

export class PageResidence extends Model {
  constructor(
    public id: number,
    public id_mdm: string,
    public slug: string,
    public active: boolean,
    public email: string,
    public phone: string,
    public city_title: string,
    public city_text: string,
    public services_text: string,
    public leadership_identity: string,
    public leadership_role: string,
    public leadership_text: string,
    public team_text: string,
    public menu_title: string,
    public menu_text: string,
    public residence: Residence,
    public address: Address,
    public assets: Asset[],
    public menus: Menu,
    public opinions_legal_text: string,
    public map_near: string,
    public apartment_text: string,
    public civiliz_id: string,
    public partoo_id: string,
    // public featured_image: MediaLibrary.MediaAttributes[],
    // public director_image: MediaLibrary.MediaAttributes[],
    // public team_image: MediaLibrary.MediaAttributes[],
    // public gallery: Array<MediaLibrary.MediaAttributes[]>,
    // public city_image: Array<MediaLibrary.MediaAttributes[]>,
    // public menu_image: MediaLibrary.MediaAttributes[],
    public apartments: Apartments
  ) {
    super(id)
  }
  toString() {
    return this.residence.name
  }
}

export class Asset {
  title = ''
  icon = ''
}

export class Menu {
  lunch = {}
  diner = {}
}

export class MenuItem {
  title = ''
  content = ''
}

export class Apartments {
  t1: ApartmentSlide[] = []
  t2: ApartmentSlide[] = []
  t3: ApartmentSlide[] = []
}

export class ApartmentSlide {
  title = ''
  text = ''
  // apartment_image: MediaLibrary.MediaAttributes[] = []
}
