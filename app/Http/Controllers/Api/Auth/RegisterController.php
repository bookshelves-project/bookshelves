<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Create a new registered user.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function register(Request $request)
    {
        $creator = new CreateNewUser();
        $user = $creator->create($request->all());
        event(new Registered($user));
        $token = $user->createToken('API'); //or device name,client,etc

        return response()->json(['token' => $token->plainTextToken]);
    }
}
