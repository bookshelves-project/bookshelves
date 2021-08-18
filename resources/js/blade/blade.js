require("../bootstrap");

require("alpinejs");

let switchColor = document.getElementById("switchColorBtn");
let html = document.getElementsByTagName("html");
html = html[0];

// if (
//   window.matchMedia &&
//   window.matchMedia("(prefers-color-scheme: dark)").matches
// ) {
//   html.classList.add("dark");
// }

let colorMode = localStorage.getItem("color-mode");
if (colorMode === "dark") {
  html.classList.add("dark");
}

function switchColorMode() {
  html.classList.toggle("dark");
  if (html.classList.contains("dark")) {
    localStorage.setItem("color-mode", "dark");
  } else {
    localStorage.setItem("color-mode", "light");
  }
}
switchColor.addEventListener("click", switchColorMode);
