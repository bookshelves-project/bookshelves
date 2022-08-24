@php
    $amount = new \NumberFormatter('fr_FR', \NumberFormatter::CURRENCY);
    $amount->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 0);
@endphp

@component('mail::message')
# Bonjour {{ $gender }} {{ $first_name }} {{ $last_name }} !

<div class="baseline"></div>

Nous vous remercions de l’intérêt que vous portez à nos solutions d’investissement en Résidence Seniors.

Voici les résultats de la simulation que vous venez de réaliser sur notre site.

Votre investissement vous rapporterait :<br>

@if (!empty($taxes_reduction))
**{{ $amount->format($taxes_reduction) }}** de réduction d'impôts sur 9 ans<br>
@endif
Un patrimoine valorisé de **{{ $amount->format($assets_development) }}**<br>
**{{ $amount->format($monthly_income) }}** de revenus mensuels, soit **{{ $amount->format($additional_income) }}** de revenus complémentaires par an net de charges et de fiscalité que votre bien soit occupé ou non.

{{-- Salutation --}}
@lang('Regards'),<br>
{{ config('app.name') }} Invest

{{-- Subcopy --}}
@slot('subcopy')
Ces résultats sont alimentés par les informations que vous avez renseignées. L'exactitude de ces résultats n'est pas garantie et ne saurait remplacer une simulation détaillée réalisée avec un professionnel du patrimoine agréé Domitys Invest au travers d'une étude personnalisée.

Que vous souhaitiez créer , valoriser ou tirer des revenus de votre patrimoine, votre conseiller réalisera avec vous une étude personnalisée de vos objectifs et critères.
@endslot
@endcomponent
