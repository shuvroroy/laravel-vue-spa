<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function () {
        return request()->user();
    });

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::patch('settings/profile', 'Settings\ProfileController@update')->name('profile.update');
    Route::patch('settings/password', 'Settings\PasswordController@update')->name('password.update');
});

Route::middleware('guest:api')->namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('register', 'RegisterController@register')->name('register');

    Route::post('email/verify/{user}', 'EmailVerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'EmailVerificationController@resend')->name('verification.resend');

    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');

    // Route::post('oauth/{driver}', 'OAuthController@redirectToProvider');
    // Route::get('oauth/{driver}/callback', 'OAuthController@handleProviderCallback')->name('oauth.callback');
});
