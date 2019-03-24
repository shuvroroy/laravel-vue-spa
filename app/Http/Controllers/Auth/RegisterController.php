<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\RegisterFormRequest;

class RegisterController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'password'));

        $token = auth()->login($user);

        return (new UserResource($user))
            ->additional([
                'meta' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ]
            ]);
    }
}
