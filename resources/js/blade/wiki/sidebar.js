let sidebarBtn = document.getElementById("sidebarBtn");
let toc = document.getElementById("toc");

function toggleSidebar() {
  toc.classList.toggle("-translate-x-full");
  toc.classList.toggle("translate-x-0");
}
sidebarBtn.addEventListener("click", toggleSidebar);

let sidebar = document.getElementById("sidebar");

document.addEventListener("click", function (event) {
  var isClickInside = sidebar.contains(event.target);

  if (!isClickInside) {
    toc.classList.remove("translate-x-0");
    toc.classList.add("-translate-x-full");
  }
});
