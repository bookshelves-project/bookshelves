@component('mail::message')
# Bonjour {{ $firstname }} {{ $lastname }} !

<div class="baseline"></div>

Votre demande de réservation a bien été envoyée.

Résumé de votre demande :
<ul>
    <li><strong>Date d'arrivée</strong> : {{ \Carbon\Carbon::parse($date_in)->format('d/m/Y') }}</li>
    <li><strong>Date de départ</strong> : {{ \Carbon\Carbon::parse($date_out)->format('d/m/Y') }}</li>
    <li><strong>Nombre de personne</strong> : {{ $nb_person }}</li>
    <li><strong>Option tarif préférentiel - Pension complète</strong> : {{ $old_person_option ? 'Oui' : 'Non' }}</li>
</ul>

{{-- Salutation --}}
@lang('Regards'),<br>
{{ config('app.name') }}
@endcomponent
