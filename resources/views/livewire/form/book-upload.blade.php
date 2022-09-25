<div class="main-container">
  <x-steward-field-upload-file
    name="covers"
    label="Covers"
    class="mt-6"
  />
  <div>
    <pre>field.editor</pre>
    <x-field.editor
      wire:model="foo"
      wire:poll.10000ms="autosave"
    ></x-field.editor>
  </div>
  <div>
    <pre>livewire:editor</pre>
    <livewire:editor />
  </div>
  <div>
    <pre>steward-field-editor</pre>
    <x-steward-field-editor wire:model="content" />
  </div>
  <x-steward-button>
    upload
  </x-steward-button>
</div>
