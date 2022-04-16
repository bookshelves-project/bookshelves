interface AlpineRefs {
  sidebarWrapper?: HTMLElement
  sidebarBackdrop?: HTMLElement
  sidebar?: HTMLElement
  sidebarCloseBtn?: HTMLElement
  sidebarToc?: HTMLElement
}

let refsAlpine: AlpineRefs

const sidebar = {
  on: false,

  toggle() {
    // const sidebarWrapper = refsAlpine.sidebarWrapper
    // const sidebarBackdrop = refsAlpine.sidebarBackdrop
    // const sidebarCloseBtn = refsAlpine.sidebarCloseBtn
    // const sidebar = refsAlpine.sidebar

    this.on = !this.on
  },
}

export default sidebar
