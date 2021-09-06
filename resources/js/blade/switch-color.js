let switchColor = document.getElementById("switchColorBtn");
let html = document.getElementsByTagName("html");
html = html[0];

function switchColorMode() {
  html.classList.toggle("dark");
  if (html.classList.contains("dark")) {
    localStorage.setItem("color-mode", "dark");
  } else {
    localStorage.setItem("color-mode", "light");
  }
}
switchColor.addEventListener("click", switchColorMode);
