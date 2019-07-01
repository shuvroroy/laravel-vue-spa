<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginFormRequest $request)
    {
        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        if (!$request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => trans('verification.unverified')
            ], 403);
        }

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ]
            ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => trans('auth.logout')
        ], 200);
    }
}
