async function copyText(text) {
  // 1) Prefer the async clipboard API when available AND in secure context (HTTPS or localhost)
  if (navigator.clipboard && window.isSecureContext) {
    try {
      await navigator.clipboard.writeText(text)
      return true
    }
    catch (err) {
      console.warn('navigator.clipboard failed, falling back to execCommand', err)
    }
  }

  // 2) Fallback for insecure contexts (HTTP) or older browsers:
  // create a tiny off-screen textarea, select it and execCommand('copy')
  const ta = document.createElement('textarea')
  ta.value = text

  // Prevent scrolling to bottom on mobile:
  ta.style.position = 'fixed'
  ta.style.left = '-9999px'
  ta.style.top = '0'
  ta.setAttribute('readonly', '') // prevent mobile keyboard from showing on focus

  document.body.appendChild(ta)

  ta.select()
  ta.setSelectionRange(0, ta.value.length)

  let successful = false
  try {
    successful = document.execCommand('copy')
  }
  catch (err) {
    console.warn('execCommand copy failed', err)
    successful = false
  }

  document.body.removeChild(ta)
  return successful
}

/* Gestion du click et retour utilisateur */
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('copyBtn')

  btn.addEventListener('click', async (ev) => {
    ev.preventDefault()
    const text = btn.dataset.copy ?? btn.textContent.trim()

    const ok = await copyText(text)

    if (ok) {
      btn.textContent = 'Copied!'
      setTimeout(() => {
        if (btn)
          btn.textContent = 'Copy preview link'
      }, 2200)
    }
  }, false)
})
