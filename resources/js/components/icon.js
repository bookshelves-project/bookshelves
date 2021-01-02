class Icon {
  constructor(name) {
    let div = document.createElement('div')
    div.innerHTML = require('../../icons/' + name + '.svg') // change to wherever your svg files are

    let fragment = document.createDocumentFragment()
    fragment.appendChild(div)

    this.svg = fragment.querySelector('svg')
  }

  classes(classes) {
    if (classes) {
      this.svg.classList = ''

      classes.split(' ').forEach((className) => {
        this.svg.classList.add(className)
      })
    }

    return this
  }

  size(size) {
    if (size) {
      this.svg.setAttribute('width', size)
      this.svg.setAttribute('height', size)
    }

    return this
  }

  width(width) {
    if (width) {
      this.svg.setAttribute('width', width)
    }

    return this
  }

  height(height) {
    if (height) {
      this.svg.setAttribute('height', height)
    }

    return this
  }

  toString() {
    return this.svg.outerHTML
  }
}

export default {
  props: ['name', 'classes', 'size', 'width', 'height'],

  render(h) {
    return h('div', {
      domProps: {
        classList: 'flex items-center',
        innerHTML: new Icon(this.name)
          .classes(this.classes)
          .size(this.size)
          .width(this.width)
          .height(this.height),
      },
    })
  },
}
