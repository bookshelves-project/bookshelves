<?php

namespace App\Filament\Pages\Auth;

use App\Facades\Bookshelves;
use Filament\Pages\Auth\Login as BasePage;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if (config('app.env') === 'local') {
            $this->form->fill([
                'email' => Bookshelves::superAdminEmail(),
                'password' => Bookshelves::superAdminPassword(),
                'remember' => true,
            ]);
        }
    }
}
