@component('mail::message')
# New contact

A new message is available!

@isset($submission)
**Name** : {{ $submission->name }}<br />
**Email**&nbsp;: <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a><br />
**Message**&nbsp;:<br />
{{ $submission->message }}
@endisset

@lang('Regards'),<br>
*{{ config('app.name') }} Team*
@endcomponent
