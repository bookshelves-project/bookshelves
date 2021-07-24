document.querySelectorAll("pre > code").forEach(function (codeBlock) {
  var button = document.createElement("button");
  button.className = "copy-code-button";
  button.type = "button";
  button.innerText = "Copy";

  button.addEventListener("click", function () {
    var copyText = codeBlock.innerText;
    console.log(copyText);
    // navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
      // navigator clipboard api method'
      return navigator.clipboard.writeText(copyText);
    } else {
      // text area method
      let textArea = document.createElement("textarea");
      textArea.value = copyText;
      // make the textarea out of viewport
      textArea.style.position = "fixed";
      textArea.style.left = "-999999px";
      textArea.style.top = "-999999px";
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();
      return new Promise((res, rej) => {
        // here the magic happens
        document.execCommand("copy") ? res() : rej();
        textArea.remove();
      });
    }
  });

  var pre = codeBlock;
  if (pre.parentNode.classList.contains("highlight")) {
    var highlight = pre.parentNode;
    highlight.parentNode.insertBefore(button, highlight);
  } else {
    pre.parentNode.insertBefore(button, pre);
  }
});
