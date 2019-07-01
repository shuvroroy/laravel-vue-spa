<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Notifications\Auth\EmailVerificationNotification;

class RegisterController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'password'));

        $user->notify(
            new EmailVerificationNotification($user)
        );

        return response()->json([
            'message' => trans('verification.sent')
        ], 201);
    }
}
