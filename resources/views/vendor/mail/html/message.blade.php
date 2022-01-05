@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => is_universe_pro() ? config('app.url-pro') : config('app.url')])
<img src="{{ is_universe_pro() ? asset('logo-pro.png') : asset('logo.png') }}" class="logo" alt="{{ config('app.name') }}">
@endcomponent
@endslot

{{-- Banner --}}
@slot('banner')
<img src="{{ is_universe_pro() ? asset('images/emails/pro-banner.jpg') : asset('images/emails/home-banner.jpg') }}" class="banner" alt="{{ config('app.name') }}">
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
<p>
    Nos conseillers sont à votre disposition pour vous accompagner<br>
    dans votre projet et réaliser avec vous une étude personnalisée.<br>
    N’hésitez pas à nous contacter au <strong>02 47 51 8000</strong><br>de <strong>9h00 à 19h</strong> du <strong>lundi au vendredi</strong>.
</p>

AEGIDE&DOMITYS, en leur qualité de responsable de traitement, collectent et traitent vos données pour répondre à votre demande, et à des fins de prospection. La base légale du traitement est votre consentement, que vous pouvez retirer à tout moment. Vos données sont transmises à nos services internes chargés de traiter votre demande. Elles sont conservées pendant une durée de 3 ans à compter de notre dernier contact. Vous pouvez exercer vos droits d’accès, de rectification, de limitation, de portabilité et d’opposition, d’effacement et de définition de vos directives post-mortem au traitement de vos données personnelles en nous contactant par courrier postal à l’adresse suivante : ÆGIDE DPO, 42, Avenue Raymond Poincaré – 75116 PARIS ou bien par courrier électronique : <a href="mailto:<a href="mailto:dpo@aegide.fr">dpo@aegide.fr</a>"><a href="mailto:dpo@aegide.fr">dpo@aegide.fr</a></a>. À tout moment, vous pouvez introduire une réclamation auprès de la [CNIL](https://www.cnil.fr/). Pour plus d’information sur le traitement de vos données : [données personnelles et politique de confidentialité]({{ url('donnees-personnelles-et-politique-de-confidentialite') }}).
@endcomponent
@endslot
@endcomponent
