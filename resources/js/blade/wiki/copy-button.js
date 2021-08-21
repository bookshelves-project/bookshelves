document.querySelectorAll('pre').forEach(function (codeBlock) {
  let original = codeBlock
  let wrapper = document.createElement('div')
  wrapper.classList.add('highlighted-block')
  wrapper.classList.add('relative')
  wrapper.appendChild(original.cloneNode(true))

  original.replaceWith(wrapper)
})

document.querySelectorAll('.highlighted-block').forEach(function (codeBlock) {
  var button = document.createElement('button')
  button.className = 'copy-code-button'
  button.type = 'button'
  button.innerText = 'Copy'
  button.addEventListener('click', function () {
    var copyText = codeBlock.childNodes.item(1).innerText
    console.log(copyText)
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
      let textArea = document.createElement('textarea')
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
      return new Promise((res, rej) => {
        // here the magic happens
        document.execCommand('copy') ? res() : rej()
        textArea.remove()
      })
    }
  })
  var pre = codeBlock.firstElementChild
  pre.parentNode.insertBefore(button, pre)
})

document.querySelectorAll('pre > code').forEach(function (codeBlock) {
  // var wrapper = document.
  // var button = document.createElement("button");
  // button.className = "copy-code-button";
  // button.type = "button";
  // button.innerText = "Copy";
  // button.addEventListener("click", function () {
  //   var copyText = codeBlock.innerText;
  //   console.log(copyText);
  //   // navigator clipboard api needs a secure context (https)
  //   if (navigator.clipboard && window.isSecureContext) {
  //     // navigator clipboard api method'
  //     button.innerText = "Copied!";
  //     setTimeout(() => {
  //       button.innerText = "Copy";
  //     }, 300);
  //     return navigator.clipboard.writeText(copyText);
  //   } else {
  //     // text area method
  //     let textArea = document.createElement("textarea");
  //     textArea.value = copyText;
  //     // make the textarea out of viewport
  //     textArea.style.position = "fixed";
  //     textArea.style.left = "-999999px";
  //     textArea.style.top = "-999999px";
  //     document.body.appendChild(textArea);
  //     textArea.focus();
  //     textArea.select();
  //     button.innerText = "Copied!";
  //     setTimeout(() => {
  //       button.innerText = "Copy";
  //     }, 300);
  //     return new Promise((res, rej) => {
  //       // here the magic happens
  //       document.execCommand("copy") ? res() : rej();
  //       textArea.remove();
  //     });
  //   }
  // });
  // var pre = codeBlock;
  // if (pre.parentNode.classList.contains("highlight")) {
  //   var highlight = pre.parentNode;
  //   highlight.parentNode.insertBefore(button, highlight);
  // } else {
  //   pre.parentNode.insertBefore(button, pre);
  // }
})
