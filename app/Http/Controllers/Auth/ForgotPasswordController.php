<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordFormRequest;
use App\Notifications\Auth\PasswordResetNotification;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(ForgotPasswordFormRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $passwordReset = PasswordReset::updateOrCreate(
            [
                'email' => $user->email
            ],
            [
                'email' => $user->email,
                'token' => str_random(60)
             ]
        );

        if ($passwordReset) {
            $user->notify(
                new PasswordResetNotification($passwordReset->token)
            );
        }

        return response()->json([
            'message' => trans('passwords.sent')
        ], 201);
    }
}
