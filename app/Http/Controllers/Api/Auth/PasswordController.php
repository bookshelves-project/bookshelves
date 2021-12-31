<?php

namespace App\Http\Controllers\Api\Auth;

class PasswordController
{
    public function forgot()
    {
        return response()->json([
            'message' => 'Success',
        ]);
    }

    public function reset()
    {
        return response()->json([
            'message' => 'Success',
        ]);
    }
}
