let refs: {
  url: HTMLElement
}

const embed = () => ({
  url: '',
  id: '',

  boot(key: string) {
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-expect-error
    refs = this.$refs
    if (refs.url.textContent)
      this.url = refs.url.textContent

    this.id = key

    document.addEventListener('DOMContentLoaded', async () => {
      setTimeout(() => {
        this.fetchIframely()
      }, 500)
    })
  },
  async fetchIframely() {
    const api = 'https://iframely.git-projects.xyz'
    const endpoint = 'iframely' // can be oembed or iframely
    const queryParams = {
      url: this.url,
      api_key: '',
      // omit_script: '1',
    }
    const query = new URLSearchParams(queryParams)
    const iframely = `${api}/${endpoint}?${query}`

    const response = await fetch(iframely)
    const data = await response.json()
    console.log(data)
    const el = document.getElementById(this.id)

    if (data.html && el) {
      let html = data.html
      html = this.stripScripts(html)
      // console.log(html)
      // const tikTokFrame = document.createElement('iframe')
      // tikTokFrame.width = '100%'
      // tikTokFrame.height = '500'
      // tikTokFrame.src = 'https://www.tiktok.com/embed/v2/6718335390845095173'

      el.innerHTML = html
      // el.appendChild(tikTokFrame)
    }
  },
  stripScripts(html: string): string {
    const SCRIPT_REGEX = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi

    while (SCRIPT_REGEX.test(html))
      html = html.replace(SCRIPT_REGEX, '')

    return html
  },

})

export default embed
