let slideBtn = document.getElementById('slideBtn')
let panelLinks = document.getElementById('panelLinks')

function togglePanelLinks() {
  panelLinks.classList.toggle('translate-x-0')
  panelLinks.classList.toggle('translate-x-full')
}
slideBtn.addEventListener('click', togglePanelLinks)

let slideOverLinks = document.getElementById('slideOverLinks')

document.addEventListener('click', function (event) {
  var isClickInside = slideOverLinks.contains(event.target)

  if (!isClickInside) {
    panelLinks.classList.remove('translate-x-0')
    panelLinks.classList.add('translate-x-full')
  }
})
