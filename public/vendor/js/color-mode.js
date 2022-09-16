const colorScheme = localStorage.getItem('color-scheme')

if (colorScheme)
  document.documentElement.classList.toggle(colorScheme, true)
else {
  const system =
    window.matchMedia &&
    window.matchMedia('(prefers-color-scheme: dark)').matches
      ? 'dark'
      : 'light'
  document.documentElement.classList.toggle(system, true)
}
