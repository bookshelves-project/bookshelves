<?php

namespace App\Filament\Pages\Auth;

use Filament\Http\Livewire\Auth\Login as BasePage;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if ('local' === config('app.env')) {
            $this->form->fill([
                'email' => config('bookshelves.admin.email'),
                'password' => config('bookshelves.admin.password'),
                'remember' => true,
            ]);
        }
    }
}
