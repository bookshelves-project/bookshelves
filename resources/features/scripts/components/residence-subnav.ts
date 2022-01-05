const residenceSubnav = () =>
  ({
    fixed: false,

    goToAnchor(elementId) {
      const element = document.getElementById(elementId)

      if (element) {
        window.scrollTo({
          top: element.offsetTop - 130,
          behavior: 'smooth',
        })
      }
    },
  } as any)

export default residenceSubnav
