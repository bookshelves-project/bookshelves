<meta name="robots" content="index, follow">
<meta name="msapplication-TileColor" content="#6C63FF">
<meta name="theme-color" content="#6C63FF">
<meta name="description" content="content">
<meta name="author" content="{{ $author }}">
<meta name="language" content="en_US">
<meta name="designer" content="{{ $author }}">
<meta name="publisher" content="{{ $author }}">
<meta name="copyright" content="BSD 2-Clause">
<meta property="og:site_name" content="Bookshelves">
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ Request::fullUrl() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ config('app.name') }}">
<meta property="og:image" content="{{ asset('assets/images/default.jpg') }}">
<meta property="og:image:alt" content="{{ config('app.name') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ Request::fullUrl() }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ config('app.name') }}">
<meta name="twitter:image" content="{{ asset('assets/images/default.jpg') }}">
