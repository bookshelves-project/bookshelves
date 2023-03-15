<?php

namespace App\Http\Livewire\Form;

use Livewire\Component;
use Livewire\WithFileUploads;

class BookUpload extends Component
{
    use WithFileUploads;

    public string $content = '';
    public mixed $upload = [];

    public function render()
    {
        return view('livewire.form.book-upload');
    }
}
