<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\PasswordForgotRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\Auth\PasswordService;

/**
 * @group User: Authentication
 */
class PasswordController extends AuthController
{
    /**
     * POST Password forgot.
     *
     * Send en email with token to User if email exist, create a PasswordReset item.
     */
    public function forgot(PasswordForgotRequest $request)
    {
        PasswordService::forgot($request);
    }

    /**
     * POST Password reset.
     *
     * Update User password if token and email are validate, send an email to User about password update.
     */
    public function reset(PasswordResetRequest $request)
    {
        PasswordService::reset($request);
    }

    /**
     * POST Password update.
     *
     * @authenticated
     */
    public function update(PasswordUpdateRequest $request)
    {
        PasswordService::update($request);
    }
}
