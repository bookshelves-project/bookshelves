@component('mail::message')
    # A new contact from {{ config('app.name') }}

    **Name** : {{ $name }}<br />
    **Email**&nbsp;: <a href="mailto:{{ $email }}">{{ $email }}</a>

    **Message**&nbsp;:<br />
    {{ $message }}

    *{{ config('app.name') }} Team*
@endcomponent
