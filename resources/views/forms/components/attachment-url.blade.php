<x-forms::field-wrapper :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <x-filament-support::button :attributes="\Filament\Support\prepare_inherited_attributes($attributes)"
            :dark-mode="config('forms.dark_mode')">
            <a :href="`{{ $getPrefix() }}${state}`"
                target="_blank">
                Voir {{ $getLabel() }}
            </a>
        </x-filament-support::button>
    </div>
</x-forms::field-wrapper>
