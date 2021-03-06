<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Settings\PasswordUpdateFormRequest;

class PasswordController extends Controller
{
    public function update(PasswordUpdateFormRequest $request)
    {
        $user = auth()->user();

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(202);
    }
}
