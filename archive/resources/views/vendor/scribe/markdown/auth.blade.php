## Authenticating requests

@if (!$isAuthed)
This API is not authenticated.
@else
{!! $authDescription !!}

{!! $extraAuthInfo !!}
@endif

## Laravel Sanctum

TODO  
`{{ config('app.url') }}/sanctum/csrf-cookie`
