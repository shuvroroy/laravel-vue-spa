<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Settings\ProfileUpdateFormRequest;

class ProfileController extends Controller
{
    public function update(ProfileUpdateFormRequest $request)
    {
        $user = auth()->user();

        $user->update($request->only('name', 'email'));

        return new UserResource($user);
    }
}
