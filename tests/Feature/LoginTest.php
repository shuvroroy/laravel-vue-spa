<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_email_and_password()
    {
        $this->json('POST', route('login'))
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'password'
                ]
            ]);
    }

    /** @test */
    public function it_returns_a_validation_error_with_invalid_email_and_password()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'invalid'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email'
                ]
            ]);
    }

    /** @test */
    public function it_returns_user_and_token_on_login()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'password'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email'
                ],
                'meta' => [
                    'token',
                    'token_type',
                    'expires_in'
                ]
            ]);
    }

    /** @test */
    public function it_requires_valid_token_to_logout()
    {
        $token = auth()->login($this->user);

        $this->withHeaders(['Authorization' => "Bearer $token"])
            ->json('POST', route('logout'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
