<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_name_valid_email_password_and_password_confirmation()
    {
        $this->json('POST', route('register'))
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'email',
                    'password'
                ]
            ]);
    }

    /** @test */
    public function it_requires_a_unique_email()
    {
        $data = [
            'email' => $this->user->email,
        ];

        $this->json('POST', route('register'), $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email'
                ]
            ]);
    }

    /** @test */
    public function it_requires_password_and_password_confirmation_do_match()
    {
        $data = [
            'password' => 'password1',
            'password_confirmation' => 'password2',
        ];

        $this->json('POST', route('register'), $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'password'
                ]
            ]);
    }

    /** @test */
    public function it_returns_user_and_token_on_registration()
    {
        $data = [
            'name' => 'John Doe',
            'email' => $email = 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $this->json('POST', route('register'), $data)
            ->assertStatus(201)
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

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }
}
