<div>
  <x-steward-field-upload-file
    name="covers"
    label="Covers"
    class="mt-6"
  />
  <x-field.editor
    wire:model="foo"
    wire:poll.10000ms="autosave"
  ></x-field.editor>
  <livewire:editor />
  <x-steward-button>
    upload
  </x-steward-button>
</div>
