const dark = {
  body: {
    background: `#444 !important`,
    color: `#fff !important`,
  },
  '*': {
    color: 'inherit !important',
    background: 'inherit !important',
  },
  'a:link': {
    color: `#1e83d2 !important`,
    'text-decoration': 'none !important',
  },
  'a:link:hover': {
    background: 'rgba(0, 0, 0, 0.1) !important',
  },
}

const light = {
  body: {},
  '*': {},
  'a:link': {},
  'a:link:hover': {},
}

const tan = {
  body: {
    background: `#fdf6e3 !important`,
    color: `#002b36 !important`,
  },
  '*': {
    color: 'inherit !important',
    background: 'inherit !important',
  },
  'a:link': {
    color: `#268bd2 !important`,
    'text-decoration': 'none !important',
  },
  'a:link:hover': {
    background: 'rgba(0, 0, 0, 0.1) !important',
  },
}

const defaultStyle = {
  body: {
    background: `#fdf6e3 !important`,
    color: `#002b36 !important`,
  },
  '*': {
    color: 'inherit !important',
    background: 'inherit !important',
  },
  'a:link': {
    color: `#268bd2 !important`,
    'text-decoration': 'none !important',
  },
  'a:link:hover': {
    background: 'rgba(0, 0, 0, 0.1) !important',
  },
  h1: {
    'font-family': 'Quicksand !important',
  },
  'p, .p': {
    background: 'inherit !important',
    'line-height': '1.5rem',
    'font-size': '1.2rem !important',
    'font-family':
      'ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important',
    'margin-top': '1.25em !important',
    'margin-bottom': '1.25em !important',
  },
}

export { dark, light, tan, defaultStyle }
