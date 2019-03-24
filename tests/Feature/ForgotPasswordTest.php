<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Auth\PasswordResetRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_a_valid_existing_email()
    {
        $data = [
            'email' => 'john@example.com'
        ];

        $this->json('POST', route('password.email'), $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ]
            ]);
    }

    /** @test */
    public function it_sends_a_email_with_a_token_and_insert_into_db_if_email_existing()
    {
        Notification::fake();

        $data = [
            'email' => $this->user->email
        ];

        $this->json('POST', route('password.email'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'message'
            ]);

        $token = PasswordReset::where('email', $this->user->email)->first()->token;

        Notification::assertSentTo(
            [$this->user],
            PasswordResetRequest::class,
            function ($notification, $channels) use ($token) {
                return $notification->token === $token;
            }
        );
    }
}