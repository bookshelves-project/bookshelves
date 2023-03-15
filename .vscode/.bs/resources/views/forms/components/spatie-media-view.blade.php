<x-forms::field-wrapper :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <x-filament-support::button :attributes="\Filament\Support\prepare_inherited_attributes($attributes)"
            :dark-mode="config('forms.dark_mode')">
            <a :href="`{{ $getPath() }}${state}`"
                target="_blank">
                View {{ $getLabel() }}
            </a>
            @dump($getType())
            @dump($getPath())
            @dump($id)
            {{-- <a :href="`{{ $getPath() }}${state}`"
                target="_blank">
                View {{ $getLabel() }}
            </a> --}}
        </x-filament-support::button>
    </div>
</x-forms::field-wrapper>
