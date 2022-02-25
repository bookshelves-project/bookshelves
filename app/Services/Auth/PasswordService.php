<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordForgotRequest;
use App\Http\Requests\PasswordUpdateRequest;

class PasswordService
{
    public const MIN_TIMEOUT = 10;
    public const MAX_TIMEOUT = 86400;

    public static function forgot(PasswordForgotRequest $request)
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $user = User::whereEmail($email)->first();

        if (! $user) {
            return response()->json([
                'message' => __('passwords.sent'),
            ]);
        }

        // if ($user) {
        // /** @var User $user */
        // $exist = PasswordReset::whereEmail($email)->get();

        // /*
        //  * Check if PasswordReset exist.
        //  */
        // if ($exist->isNotEmpty()) {
        //     /** @var PasswordReset $first */
        //     $first = $exist->first();
        //     $date = $first->created_at;

        //     $now = Carbon::now();
        //     $difference = Carbon::parse($date)->diffInSeconds($now);

        //     /*
        //      * Check date, reject if below 30 seconds.
        //      */
        //     if ($difference < self::MIN_TIMEOUT) {
        //         return response()->json([
        //             'message' => __('passwords.throttled'),
        //         ], 401);
        //     }

        //     /*
        //      * Delete other tokens.
        //      */
        //     foreach ($exist as $value) {
        //         $value->delete();
        //     }
        // }

        // $base = Str::random(50);
        // $token = Hash::make($base);
        // /*
        //  * Create new PasswordReset.
        //  */
        // PasswordReset::create([
        //     'email' => $email,
        //     'token' => $token,
        // ]);
        // // Send email with token
        // $user->sendPasswordResetNotification($base);
        // }

        return response()->json([
            'message' => __('passwords.sent'),
        ]);
    }

    public static function reset(PasswordResetRequest $request)
    {
        $validated = $request->validated();

        // $passwordReset = PasswordReset::whereEmail($validated['email'])->first();

        // /*
        //  * Check if PasswordReset is available.
        //  * And check token.
        //  */
        // if ($passwordReset) {
        // $date = $passwordReset->created_at;
        // $now = Carbon::now();
        // $difference = Carbon::parse($date)->diffInSeconds($now);

        // if ($difference < self::MAX_TIMEOUT && Hash::check($validated['token'], $passwordReset->token)) {
        //     // Find User
        //     $user = User::whereEmail($validated['email'])->firstOrFail();
        //     // Update password
        //     $user->update([
        //         'password' => Hash::make($validated['password']),
        //     ]);
        //     $user->save();

        //     // Send notification
        //     $user->sendPasswordUpdatedNotification();
        //     // Delete current PasswordReset
        //     $passwordReset->delete();

        //     return response()->json([
        //         'message' => __('passwords.reset'),
        //     ]);
        // }
        // }

        return response()->json([
            'message' => __('passwords.token'),
        ], 401);
    }

    public static function update(PasswordUpdateRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $validated = $request->validated();

        if (Hash::check($request->current_password, $user->password)) {
            if ($request->password === $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            return response()->json([
                'message' => __('passwords.updated'),
            ]);
        }

        return response()->json([
            'message' => __('auth.password'),
        ], 401);
    }
}
