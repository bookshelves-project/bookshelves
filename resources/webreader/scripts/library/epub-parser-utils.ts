export default class EpubParserUtils {
  measureText = (string: string, fontSize: number) => {
    const widths = [
      0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
      0, 0, 0, 0, 0, 0, 0, 0.2796875, 0.2765625, 0.3546875, 0.5546875,
      0.5546875, 0.8890625, 0.665625, 0.190625, 0.3328125, 0.3328125, 0.3890625,
      0.5828125, 0.2765625, 0.3328125, 0.2765625, 0.3015625, 0.5546875,
      0.5546875, 0.5546875, 0.5546875, 0.5546875, 0.5546875, 0.5546875,
      0.5546875, 0.5546875, 0.5546875, 0.2765625, 0.2765625, 0.584375,
      0.5828125, 0.584375, 0.5546875, 1.0140625, 0.665625, 0.665625, 0.721875,
      0.721875, 0.665625, 0.609375, 0.7765625, 0.721875, 0.2765625, 0.5,
      0.665625, 0.5546875, 0.8328125, 0.721875, 0.7765625, 0.665625, 0.7765625,
      0.721875, 0.665625, 0.609375, 0.721875, 0.665625, 0.94375, 0.665625,
      0.665625, 0.609375, 0.2765625, 0.3546875, 0.2765625, 0.4765625, 0.5546875,
      0.3328125, 0.5546875, 0.5546875, 0.5, 0.5546875, 0.5546875, 0.2765625,
      0.5546875, 0.5546875, 0.221875, 0.240625, 0.5, 0.221875, 0.8328125,
      0.5546875, 0.5546875, 0.5546875, 0.5546875, 0.3328125, 0.5, 0.2765625,
      0.5546875, 0.5, 0.721875, 0.5, 0.5, 0.5, 0.3546875, 0.259375, 0.353125,
      0.5890625,
    ]
    const avg = 0.5279276315789471
    return (
      Array.from(string).reduce(
        (acc, cur) => acc + (widths[cur.charCodeAt(0)] ?? avg),
        0
      ) * fontSize
    )
  }

  /**
   * Uses canvas.measureText to compute and return the width of the given text of given font in pixels.
   *
   * @param {String} text The text to be rendered.
   * @param {String} font The css font descriptor that text is to be rendered with (e.g. "bold 14px verdana").
   *
   * @see https://stackoverflow.com/questions/118241/calculate-text-width-with-javascript/21015393#21015393
   */
  getTextHeight = (text: string, font: string) => {
    const canvas = document.createElement('canvas')
    const context = canvas.getContext('2d')
    if (context) {
      context.font = font
      const metrics = context.measureText(text)
    }

    // return metrics.height
  }

  getTextWidth = (text, font) => {
    const canvas = document.createElement('canvas')
    const context = canvas.getContext('2d')
    if (context) {
      context.font = font
      const metrics = context.measureText(text)
      return metrics.width
    }
  }

  getCssStyle = (element, prop) => {
    return window.getComputedStyle(element, null).getPropertyValue(prop)
  }

  getCanvasFontSize = (el = document.body) => {
    const fontWeight = this.getCssStyle(el, 'font-weight') || 'normal'
    const fontSize = this.getCssStyle(el, 'font-size') || '16px'
    const fontFamily = this.getCssStyle(el, 'font-family') || 'Times New Roman'

    return `${fontWeight} ${fontSize} ${fontFamily}`
  }

  /**
   * Remove tags from HTML `string`, tags can be keep with `tags` `string[]`.
   * The `<head>` will be removed if `removeHead` is `true`.
   *
   * From https://stackoverflow.com/a/66772951/11008206
   */
  stripTags = (html: string, tags: string[] = [], removeHead = false) => {
    if (removeHead) {
      const parser = new DOMParser()
      const xmlDoc = parser.parseFromString(html, 'text/xml')
      const document = xmlDoc.getElementsByTagName('body')[0]
      html = document.innerHTML
    }
    html = html
      .replace(/<(\/?)(\w+)[^>]*\/?>/g, (_, endMark, tag) =>
        tags.includes(tag) ? '<' + endMark + tag + '>' : ''
      )
      .replace(/<!--.*?-->/g, '')
    html = html.replace(/>\s+</g, '><')

    return html
  }

  /**
   * Divide string into chunks
   */
  chunkString = (str: string, length = 80) => {
    const input = str.trim().split(' ')
    let index = 0
    const output: string[] = []
    output[index] = ''
    input.forEach((word) => {
      const temp = `${output[index]} ${word}`.trim()
      if (temp.length <= length) {
        output[index] = temp
      } else {
        index++
        output[index] = word
      }
    })

    return output
  }

  splitString(str: string, n: number) {
    const arr = str?.split(' ')
    const result: string[] = []
    let subStr = arr[0]
    for (let i = 1; i < arr.length; i++) {
      const word = arr[i]
      if (subStr.length + word.length + 1 <= n) {
        subStr = subStr + ' ' + word
      } else {
        result.push(subStr)
        subStr = word
      }
    }
    if (subStr.length) {
      result.push(subStr)
    }
    return result
  }
}
