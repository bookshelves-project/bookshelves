@component('mail::message')
  # A new contact from Bookshelves

  **Name** : {{ $name }}<br />
  **Email**&nbsp;: <a href="mailto:{{ $email }}">{{ $email }}</a>

  **Message**&nbsp;:<br />
  {{ $message }}

  *Bookshelves Team*
@endcomponent
