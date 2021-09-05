let slideOver = document.getElementById("slide-over");
let slideOverCloseButton = document.getElementById("slide-over-close-button");
let slideOverBackdrop = document.getElementById("slide-over-backdrop");

if (slideOver && slideOverCloseButton && slideOverBackdrop) {
  function toggleSlideOver(toOpen = true) {
    let slideOverWrapper = document.getElementById("slide-over-wrapper");

    if (toOpen) {
      slideOverWrapper.classList.toggle("hidden");

      setTimeout(() => {
        slideOverBackdrop.classList.toggle("opacity-0");
        slideOverBackdrop.classList.toggle("opacity-100");
        setTimeout(() => {
          slideOver.classList.toggle("translate-x-full");
          slideOver.classList.toggle("translate-x-0");
        }, 150);
      }, 150);
    } else {
      slideOver.classList.toggle("translate-x-full");
      slideOver.classList.toggle("translate-x-0");

      setTimeout(() => {
        slideOverBackdrop.classList.toggle("opacity-0");
        slideOverBackdrop.classList.toggle("opacity-100");
        setTimeout(() => {
          slideOverWrapper.classList.toggle("hidden");
        }, 150);
      }, 150);
    }

    let status = slideOver.getAttribute("data-status") === "true";
    slideOver.setAttribute("data-status", !status);
  }

  let slideOverHeaderButton = document.getElementById(
    "slide-over-header-button"
  );
  slideOverHeaderButton.addEventListener("click", () => {
    toggleSlideOver(true);
  });

  let slideOverCloseButtonBtn = slideOverCloseButton.firstElementChild;
  slideOverCloseButtonBtn.addEventListener("click", () => {
    toggleSlideOver(false);
  });

  document.addEventListener("click", (evt) => {
    let targetElement = evt.target; // clicked element

    if (targetElement == slideOverBackdrop) {
      toggleSlideOver(false);
    } else {
      return;
    }
  });
}
