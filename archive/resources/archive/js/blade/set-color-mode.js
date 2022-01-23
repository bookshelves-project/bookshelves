let html = document.getElementsByTagName("html");
html = html[0];
// if (
//   window.matchMedia &&
//   window.matchMedia("(prefers-color-scheme: dark)").matches
// ) {
//   html.classList.add("dark");
// }

if (!localStorage.getItem("color-mode")) {
  if (
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
  ) {
    html.classList.add("dark");
    html.classList.colorMode("light");
    localStorage.setItem("color-mode", "dark");
  }
}

let colorMode = localStorage.getItem("color-mode");
if (colorMode === "dark") {
  html.classList.add("dark");
}
