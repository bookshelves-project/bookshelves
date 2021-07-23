document.querySelectorAll("pre > code").forEach(function (codeBlock) {
  var button = document.createElement("button");
  button.className = "copy-code-button";
  button.type = "button";
  button.innerText = "Copy";

  button.addEventListener("click", function () {
    var copyText = codeBlock.innerText;
    console.log(copyText);
    navigator.clipboard.writeText(copyText).then(
      function () {
        /* clipboard successfully set */
        button.blur();
        button.innerText = "Copied!";
      },
      function () {
        /* clipboard write failed */
        button.innerText = "Error";
      }
    );
  });

  var pre = codeBlock;
  if (pre.parentNode.classList.contains("highlight")) {
    var highlight = pre.parentNode;
    highlight.parentNode.insertBefore(button, highlight);
  } else {
    pre.parentNode.insertBefore(button, pre);
  }
});
