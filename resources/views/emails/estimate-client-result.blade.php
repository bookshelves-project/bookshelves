@php
    $amount = new \NumberFormatter('fr_FR', \NumberFormatter::CURRENCY);
    $amount->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 0);
@endphp

@component('mail::message')
# Bonjour {{ $gender }} {{ $first_name }} {{ $last_name }} !

<div class="baseline"></div>

Nous avons le plaisir de vous transmettre ci-dessous les tarifs correspondants à votre demande du {{ date('d/m/Y') }}.

Votre besoin :

**Résidence souhaitée** : [{{ $residence_name }}]({{ $residence_url }})<br>
**Nombre de personnes** : {{ $persons }}

Votre offre :

Loyer en appartement T{{ $rooms }} pour {{ $persons }} {{ Str::lower(trans_choice('Persons', $persons)) }} à partir de {{ $amount->format($price) }} /mois *

Vos services optionnels :

- Pack Gourmet Déjeuner quotidien au restaurant, un large choix de plats savoureux préparés par un Chef : 445,00 € /mois

Total : **{{ $amount->format($price) }}** /mois *

\* Hors forfait d'installation et honoraires de mise en location. Prix pour une personne incluant la location d'un T1, charges locatives<br>
** comprises ainsi que les services du Club DOMITYS — sous réserve de disponibilité.<br>
** Provisions ou forfait selon les résidences — pour plus de renseignements contacter un conseiller.

{{-- Salutation --}}
@lang('Regards'),<br>
{{ config('app.name') }}

{{-- Subcopy --}}
@slot('subcopy')
Ces résultats sont alimentés par les informations que vous avez renseignées. L'exactitude de ces résultats n'est pas garantie et ne saurait remplacer une simulation détaillée réalisée avec un professionnel du patrimoine agréé Domitys Invest au travers d'une étude personnalisée.

Que vous souhaitiez créer , valoriser ou tirer des revenus de votre patrimoine, votre conseiller réalisera avec vous une étude personnalisée de vos objectifs et critères.
@endslot
@endcomponent
