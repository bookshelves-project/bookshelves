const makeNavLinksSmooth = () => {
  const navLinks = document.querySelectorAll(".nav-link");

  for (let n in navLinks) {
    if (navLinks.hasOwnProperty(n)) {
      navLinks[n].addEventListener("click", (e) => {
        e.preventDefault();
        document.querySelector(navLinks[n].hash).scrollIntoView({
          behavior: "smooth",
        });
      });
    }
  }
};

const spyScrolling = () => {
  const sections = document.querySelectorAll(".hero-bg");

  window.onscroll = () => {
    const scrollPos =
      document.documentElement.scrollTop || document.body.scrollTop;

    for (let s in sections)
      if (sections.hasOwnProperty(s) && sections[s].offsetTop <= scrollPos) {
        const id = sections[s].id;
        try {
          document.querySelector(".active").classList.remove("active");
        } catch (error) {}
        let id_strip = id.replace(/(<([^>]+)>)/gi, "");
        id_strip = id_strip.replace(/[^a-zA-Z ]/g, "");
        id_strip = id_strip.replace("heading", "");
        document
          .querySelector(`#${id_strip}`)
          .parentNode.classList.add("active");
      }
  };
};

makeNavLinksSmooth();
spyScrolling();
