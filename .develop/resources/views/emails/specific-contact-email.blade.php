@component('mail::message')
# Bonjour

<div class="baseline"></div>

Vous avez reçu une demande de contact.

Identité de la personne :
<ul>
    <li><strong>Civilité</strong> : {{ App\Enums\GenderEnum::from($gender)->name }}</li>
    <li><strong>Identité</strong> : {{ $first_name }} {{ $last_name }}</li>
    <li><strong>Téléphone</strong> : {{ $phone }}</li>
    <li><strong>Email</strong> : {{ $email }}</li>
    <li><strong>Recevoir l'actualité et les offres Domitys</strong> : {{ !empty($optin) ? 'Oui' : 'Non' }}</li>
</ul>

@if($comment)
Commentaire :

{{ $comment }}
@endif

{{-- Salutation --}}
@lang('Regards'),<br>
{{ config('app.name') }}
@endcomponent
