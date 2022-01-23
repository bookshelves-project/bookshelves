<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Config;
use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        $password = new Password();

        if (! Config::get('app.debug')) {
            $password
                ->requireNumeric()
                ->requireUppercase()
                ->requireSpecialCharacter()
            ;
        }

        return ['required', 'string', $password, 'confirmed'];
    }
}
