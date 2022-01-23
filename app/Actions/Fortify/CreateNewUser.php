<?php

namespace App\Actions\Fortify;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        abort_if(! config('auth.registration'), 404);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create(Arr::only($input, ['name', 'email', 'password']) + [
            'role' => User::count() ? RoleEnum::user()->value : RoleEnum::super_admin()->value,
        ]);
    }
}
