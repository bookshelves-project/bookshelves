export interface Column {
  field: string
  source?: string
  label?: string
  width?: number | string
  numeric?: boolean
  centered?: boolean
  sortable?: boolean
  searchable?: boolean
  type?: string
  props?: any
  filterType?: string
}
