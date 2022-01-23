let sidebar = document.getElementById("sidebar");
let sidebarCloseButton = document.getElementById("sidebar-close-button");
let sidebarBackdrop = document.getElementById("sidebar-backdrop");
if (sidebar && sidebarCloseButton && sidebarBackdrop) {
  function toggleSidebar(toOpen = true) {
    let sidebarWrapper = document.getElementById("sidebar-wrapper");

    if (toOpen) {
      sidebarWrapper.classList.toggle("hidden");
      sidebarWrapper.classList.toggle("flex");

      setTimeout(() => {
        sidebarBackdrop.classList.toggle("opacity-0");
        sidebarBackdrop.classList.toggle("opacity-100");
        setTimeout(() => {
          sidebar.classList.toggle("-translate-x-full");
          sidebar.classList.toggle("translate-x-0");
          sidebarCloseButton.classList.toggle("opacity-0");
          sidebarCloseButton.classList.toggle("opacity-100");
        }, 150);
      }, 150);
    } else {
      sidebar.classList.toggle("-translate-x-full");
      sidebar.classList.toggle("translate-x-0");
      sidebarCloseButton.classList.toggle("opacity-0");
      sidebarCloseButton.classList.toggle("opacity-100");

      setTimeout(() => {
        sidebarBackdrop.classList.toggle("opacity-0");
        sidebarBackdrop.classList.toggle("opacity-100");
        setTimeout(() => {
          sidebarWrapper.classList.toggle("hidden");
          sidebarWrapper.classList.toggle("flex");
        }, 150);
      }, 150);
    }

    let status = sidebar.getAttribute("data-status") === "true";
    sidebar.setAttribute("data-status", !status);
  }

  let sidebarHeaderButton = document.getElementById("sidebar-header-button");
  if (sidebarHeaderButton) {
    sidebarHeaderButton.addEventListener("click", () => {
      toggleSidebar(true);
    });
  }

  let sidebarCloseButtonBtn = sidebarCloseButton.firstElementChild;
  if (sidebarCloseButtonBtn) {
    sidebarCloseButtonBtn.addEventListener("click", () => {
      toggleSidebar(false);
    });
  }

  document.addEventListener("click", (evt) => {
    let targetElement = evt.target; // clicked element

    if (targetElement == sidebarBackdrop) {
      toggleSidebar(false);
    } else {
      return;
    }
  });
}
