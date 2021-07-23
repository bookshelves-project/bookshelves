let sidebarBtn = document.getElementById("sidebarBtn");
let toc = document.getElementById("toc");

function toggleSidebar() {
  toc.classList.toggle("-translate-x-full");
  toc.classList.toggle("translate-x-0");
}
sidebarBtn.addEventListener("click", toggleSidebar);
