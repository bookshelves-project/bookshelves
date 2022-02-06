const codeblock = () => {
  document.querySelectorAll('pre').forEach(function (codeBlock) {
    const original = codeBlock
    const wrapper = document.createElement('div')
    wrapper.classList.add('highlighted-block')
    wrapper.classList.add('relative')
    wrapper.appendChild(original.cloneNode(true))

    original.replaceWith(wrapper)
  })

  document.querySelectorAll('.highlighted-block').forEach(function (codeBlock) {
    const button = document.createElement('button')
    button.className = 'copy-code-button'
    button.type = 'button'
    button.innerText = 'Copy'
    button.addEventListener('click', function () {
      const copyText = codeBlock.childNodes.item(1).textContent as string
      // navigator clipboard api needs a secure context (https)
      if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        button.innerText = 'Copied!'
        setTimeout(() => {
          button.innerText = 'Copy'
        }, 300)
        return navigator.clipboard.writeText(copyText)
      } else {
        // text area method
        const textArea = document.createElement('textarea')
        textArea.value = copyText
        // make the textarea out of viewport
        textArea.style.position = 'fixed'
        textArea.style.left = '-999999px'
        textArea.style.top = '-999999px'
        document.body.appendChild(textArea)
        textArea.focus()
        textArea.select()
        button.innerText = 'Copied!'
        setTimeout(() => {
          button.innerText = 'Copy'
        }, 300)
        return new Promise<void>((res, rej) => {
          // here the magic happens
          document.execCommand('copy') ? res() : rej()
          textArea.remove()
        })
      }
    })
    const pre = codeBlock.firstElementChild
    pre?.parentNode?.insertBefore(button, pre)
  })
}

export default codeblock
