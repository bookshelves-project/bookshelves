/**
 * Thanks to Xyfir
 * https://github.com/Xyfir/xyfir-reader
 */

/**
 * Listen for clicks and convert them to actions based on the location of the
 * click on the page.
 * @param {Document} document - The document to add event listeners to.
 * @param {Object} rendition - EPUBJS rendition
 * @param {function} fn - The listener function.
 */

const mouseListener = (document, rendition, fn) => {
  document.addEventListener(
    'click',
    (event) => {
      if (event.ignore)
        return
      event.ignore = true

      // User selected text
      if (document.getSelection().toString())
        return

      // Get book iframe window's size
      const wX = document.body.clientWidth
      // const wY = document.body.clientHeight;

      // Get click location
      const cX = event.clientX - (rendition.manager.scrollLeft || 0)
      // const cY = event.clientY;

      // Click was in left 20% of page
      if (cX < wX * 0.2)
        fn('prev')
      // Click was in right 20% of page
      else if (cX > wX - wX * 0.2)
        fn('next')
    },
    false,
  )
}

/**
 * Listen for key press
 * @param {HTMLElement} el - The element to add event listeners to.
 * @param {function} fn - The listener function.
 */

const keyListener = (el, fn) => {
  el.addEventListener(
    'keyup',
    (e) => {
      // Right or up arrow key indicates next
      if (e.keyCode === 39 || e.keyCode === 38)
        fn('next')

      // left or down arrow key indicates next
      else if (e.keyCode === 37 || e.keyCode === 40)
        fn('prev')
    },
    false,
  )
}

/**
 * @param {Document} document - The document object to add event
 * @param {Object} rendition - The EPUBJS rendition
 * @param {Function} fb - The listener function
 */
const selectListener = (document, rendition, fn) => {
  document.addEventListener('mousedown', () => {
    document.getSelection().removeAllRanges()
    fn('cleared')
  })

  document.addEventListener('mouseup', (e) => {
    if (e.ignore)
      return
    e.ignore = true

    const selection = document.getSelection()
    const text = selection.toString()

    if (text === '')
      return
    const range = selection.getRangeAt(0)

    const [contents] = rendition.getContents()
    const cfiRange = contents.cfiFromRange(range)

    const SelectionReact = range.getBoundingClientRect()
    const viewRect = rendition.manager.container.getBoundingClientRect()

    const react = {
      left: `${
        viewRect.x + SelectionReact.x - (rendition.manager.scrollLeft || 0)
      }px`,
      top: `${viewRect.y + SelectionReact.y}px`,
      width: `${SelectionReact.width}px`,
      height: `${SelectionReact.height}px`,
    }
    fn('selected', react, text, cfiRange)
  })
}

/**
 * Thanks to Xyfir
 * https://github.com/Xyfir/xyfir-reader
 */

/**
 * Listen for swipes convert them to actions.
 * @param {Document} document - The document to add event listeners to.
 * @param {function} fn - The listener function.
 */
const swipListener = (document, fn) => {
  // Defaults: 100, 350, 100
  // Required min distance traveled to be considered swipe
  const threshold = 50
  // Maximum time allowed to travel that distance
  const allowedTime = 500
  // Maximum distance allowed at the same time in perpendicular direction
  const restraint = 200

  let startX
  let startY
  let startTime

  document.addEventListener(
    'touchstart',
    (e) => {
      if (e.ignore)
        return
      e.ignore = true

      startX = e.changedTouches[0].pageX
      startY = e.changedTouches[0].pageY
      startTime = Date.now()
    },
    false,
  )

  document.addEventListener(
    'touchend',
    (e) => {
      if (e.ignore)
        return
      e.ignore = true

      // Get distance traveled by finger while in contact with surface
      const distX = e.changedTouches[0].pageX - startX
      const distY = e.changedTouches[0].pageY - startY

      // Time elapsed since touchstart
      const elapsedTime = Date.now() - startTime

      if (elapsedTime <= allowedTime) {
        // Horizontal swipe
        if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint)
        // If dist traveled is negative, it indicates left swipe
        { fn(distX < 0 ? 'prev' : 'next') }
        // Vertical swipe
        else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint)
        // If dist traveled is negative, it indicates up swipe
        { fn(distY < 0 ? 'up' : 'down') }
        // Tap
        else {
          document.defaultView.getSelection().removeAllRanges()

          // Convert tap to click
          document.dispatchEvent(
            new MouseEvent('click', {
              clientX: startX,
              clientY: startY,
            }),
          )

          // !! Needed to prevent double 'clicks' in certain environments
          e.preventDefault()
        }
      }
    },
    false,
  )
}

/**
 * Listen for wheel and convert them to next or prev action based on direction.
 * @param {HTMLElement} el - The element to add event listeners to.
 * @param {function} fn - The listener function.
 */

const wheelListener = (el, fn) => {
  // Required min distance traveled to be considered swipe
  const threshold = 750
  // Maximum time allowed to travel that distance
  const allowedTime = 50

  let dist = 0
  let isScrolling

  el.addEventListener('wheel', (e) => {
    if (e.ignore)
      return
    e.ignore = true

    clearTimeout(isScrolling)

    dist += e.deltaY

    isScrolling = setTimeout(() => {
      if (Math.abs(dist) >= threshold) {
        // If wheel scrolled down it indicates left
        const direction = Math.sign(dist) > 0 ? 'next' : 'prev'
        fn(direction)
        dist = 0
      }

      dist = 0
    }, allowedTime)
  })
}

export { selectListener, swipListener, wheelListener, keyListener }
