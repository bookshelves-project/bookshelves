@component('mail::message')
# A new contact from {{ config('app.name') }}

<div class="baseline"></div>

**Name** : {{ $name }}<br />
**Email**&nbsp;: <a href="mailto:{{ $email }}">{{ $email }}</a><br />
**Message**&nbsp;:<br />
{{ $message }}

{{-- Salutation --}}
@lang('Regards'),<br>
*{{ config('app.name') }} Team*
@endcomponent
