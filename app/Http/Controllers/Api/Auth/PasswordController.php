<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordForgotRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /**
     * Send en email with token to User if email exist, create a PasswordReset item.
     */
    public function forgot(PasswordForgotRequest $request)
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $user = User::whereEmail($email)->first();

        if ($user) {
            /** @var User $user */
            $exist = PasswordReset::whereEmail($email)->get();

            /**
             * Check if PasswordReset exist.
             */
            if ($exist->isNotEmpty()) {
                /** @var PasswordReset $first */
                $first = $exist->first();
                $date = $first->created_at;

                $now = Carbon::now();
                $difference = Carbon::parse($date)->diffInSeconds($now);

                /**
                 * Check date, reject if below 30 seconds.
                 */
                if ($difference < 30) {
                    return response()->json([
                        'message' => __('passwords.throttled'),
                    ], 401);
                }

                /**
                 * Delete other tokens.
                 */
                foreach ($exist as $value) {
                    $value->delete();
                }
            }

            $base = Str::random(50);
            $token = Hash::make($base);
            /**
             * Create new PasswordReset.
             */
            PasswordReset::create([
                'email' => $email,
                'token' => $token,
            ]);
            // Send email with token
            $user->sendPasswordResetNotification($base);

            return response()->json([
                'message' => __('passwords.sent'),
            ]);
        }

        return response()->json([
            'message' => __('passwords.throttled'),
        ], 401);
    }

    /**
     * Update User password if token and email are validate, send an email to User about password update.
     */
    public function reset(PasswordResetRequest $request)
    {
        $validated = $request->validated();

        $passwordReset = PasswordReset::whereEmail($validated['email'])->first();

        /**
         * Check if PasswordReset is available.
         * And check token.
         */
        if ($passwordReset && Hash::check($validated['token'], $passwordReset->token)) {
            // Find User
            $user = User::whereEmail($validated['email'])->firstOrFail();
            // Update password
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
            $user->save();

            // Send notification
            $user->sendPasswordUpdatedNotification();
            // Delete current PasswordReset
            $passwordReset->delete();

            return response()->json([
                'message' => __('passwords.reset'),
            ]);
        }

        return response()->json([
            'message' => __('passwords.token'),
        ], 401);
    }
}
