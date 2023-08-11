<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BasePage;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if ('local' === config('app.env')) {
            $this->form->fill([
                'email' => config('app.admin.email'),
                'password' => config('app.admin.password'),
                'remember' => true,
            ]);
        }
    }
}
