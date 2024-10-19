export interface Metadata {
  altIdentifier: {
    scheme: string
    value: string
  }[]
  author: {
    name: string
    role: string
  }
  belongsTo: {
    name: string
    position: number
  }
  contributor: {
    name: string
    role: string
  }
  description: string
  identifier: string
  language: string
  published: string
  publisher: string
  sortAs: string
  subject: string[]
  title: string
}

export interface ManifestItem {
  href: string
  id: string
  mediaOverlay: string
  mediaType: string
  properties: string
}

export interface Resources {
  cfis: string[]
  cover: ManifestItem
  guide: {
    href: string
    label: string
    type: string[]
  }[]
  manifest: ManifestItem[]
  navPath: string
  ncxPath: string
  opf: OpfItem
  pageProgressionDirection: any
  spine: {
    id: any
    idref: string
    linear: any
    properties: any
  }
}

export interface OpfItem {
  URL: string
  activeElement: Element | null // Assuming this refers to an XML or HTML element.
  adoptedStyleSheets: Array<any> // Array for adopted stylesheets, could be `StyleSheet[]` if they are.
  alinkColor: string
  all: HTMLAllCollection
  anchors: HTMLCollection
  applets: HTMLCollection
  baseURI: string
  bgColor: string
  body: HTMLElement | null
  characterSet: string
  charset: string
  childElementCount: number
  childNodes: NodeList
  children: HTMLCollection
  compatMode: string
  contentType: string
  cookie: string
  currentScript: HTMLScriptElement | null
  defaultView: Window | null
  designMode: string
  dir: string
  doctype: DocumentType | null
  documentElement: Element
  documentURI: string
  domain: string
  embeds: HTMLCollection
  fgColor: string
  firstChild: Node
  firstElementChild: Element
  fonts: FontFaceSet
  forms: HTMLCollection
  fragmentDirective: object
  fullscreen: boolean
  fullscreenElement: Element | null
  fullscreenEnabled: boolean
  head: HTMLHeadElement | null
  hidden: boolean
  images: HTMLCollection
  implementation: DOMImplementation
  inputEncoding: string
  isConnected: boolean
  lastChild: Node
  lastElementChild: Element
  lastModified: string
  lastStyleSheetSet: string | null
  linkColor: string
  links: HTMLCollection
  mozFullScreen: boolean
  mozFullScreenElement: Element | null
  mozFullScreenEnabled: boolean
  nextSibling: Node | null
  nodeName: string
  nodeType: number
  nodeValue: string | null
  onabort: ((this: Document, ev: UIEvent) => any) | null
  ownerDocument: Document | null
  parentElement: Element | null
  parentNode: Node | null
  plugins: HTMLCollection
  pointerLockElement: Element | null
  preferredStyleSheetSet: string
  previousSibling: Node | null
  readyState: string
  referrer: string
  rootElement: Element | null
  scripts: HTMLCollection
  scrollingElement: Element | null
  selectedStyleSheetSet: string
  styleSheetSets: DOMStringList
  styleSheets: StyleSheetList
  textContent: string | null
  timeline: DocumentTimeline
  title: string
  visibilityState: string
  vlinkColor: string
  location: Location
  prototype: Document
}

export interface TocItem {
  href: string
  label: string
  subitems: any
}

export interface Ebook {
  dir: undefined
  getSize: (name: string) => any
  landmarks: {
    href: string
    label: string
    type: string[]
  }[]
  loadBlob: (name: string) => any
  loadText: (name: string) => any
  media: object
  metadata: Metadata
  pageList: any
  parser: DOMParser
  rendition: object
  resources: Resources
  sections: {
    cfi: string
    createDocument: () => any
    id: string
    linear: any
    load: () => any
    mediaOverlay: any
    pageSpread: any
    resolveHref: (href: string) => any
    size: number
    unload: () => any
  }[]
  toc: TocItem[]
}
