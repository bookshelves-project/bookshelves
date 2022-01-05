@component('mail::message')
# Bonjour

<div class="baseline"></div>

Une nouvelle demande de réservation vient de vous être adressé.

Identité de la personne :
<ul>
    <li><strong>Identité</strong> : {{ $firstname }} {{ $lastname }}</li>
    <li><strong>Téléphone</strong> : {{ $phone }}</li>
    <li><strong>Email</strong> : {{ $email }}</li>
    <li><strong>Code partenaire</strong> : {{ $partner_code }}</li>
</ul>

Résumé de la demande :
<ul>
    <li><strong>Date d'arrivée</strong> : {{ \Carbon\Carbon::parse($date_in)->format('d/m/Y') }}</li>
    <li><strong>Date de départ</strong> : {{ \Carbon\Carbon::parse($date_out)->format('d/m/Y') }}</li>
    <li><strong>Nombre de personne</strong> : {{ $nb_person }}</li>
    <li><strong>Option tarif préférentiel - Pension complète</strong> : {{ $old_person_option ? 'Oui' : 'Non' }}</li>
</ul>

@if($message)
Message complémentaire :

{{ $message }}
@endif

{{-- Salutation --}}
@lang('Regards'),<br>
{{ config('app.name') }}
@endcomponent
