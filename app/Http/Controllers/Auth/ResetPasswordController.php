<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordFormRequest;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordFormRequest $request)
    {
        $passwordReset = $this->find($request->token, $request->email);

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();

        return response()->json([
            'message' => 'Your password has been reset!'
        ], 202);
    }

    protected function find($token, $email)
    {
        $passwordReset = PasswordReset::where([
            ['token', $token],
            ['email', $email]
        ])->first();

        if (!$passwordReset) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => 'This password reset token is invalid.'
                ]
            ], 422);
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => 'This password reset token is invalid.'
                ]
            ], 422);
        }

        return $passwordReset;
    }
}
