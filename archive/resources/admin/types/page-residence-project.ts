import { Model } from './model'
import { Address } from './address'
import { ResidenceProject } from './residence-project'
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'

export class PageResidenceProject extends Model {
  constructor(
    public id: number,
    public id_mdm: string,
    public address: Address,
    public slug: string,
    public active: boolean,
    public project: ResidenceProject,
    public phone: string,
    public summary: string,
    public delivery_date: string,
    public call_price: number,
    public law: string,
    public marketing_list: string,
    public plan_title: string,
    public plan_list: string[],
    public lot_title: string,
    public lot_legal: string,
    public lot_cta_link: string,
    public lot_cta_text: string,
    public lot_1_call_price: number,
    public lot_1_caption: string,
    public lot_2_call_price: number,
    public lot_2_caption: string,
    public lot_3_call_price: number,
    public lot_3_caption: string,
    public contact_text_1: string,
    public contact_text_2: string,
    public contact_cta_link: string,
    public contact_cta_text: string,
    public map_title: string,
    public map_list: MapItem[],
    public map_text: string,
    public invest_title: string,
    public invest_text: string // public featured_image: MediaLibrary.MediaAttributes[], // public gallery: Array<MediaLibrary.MediaAttributes[]>, // public plan_image: MediaLibrary.MediaAttributes[], // public invest_image: MediaLibrary.MediaAttributes[]
  ) {
    super(id)
  }
  toString() {
    return this.project.name
  }
}

export class MapItem {
  title = ''
  icon = ''
}
