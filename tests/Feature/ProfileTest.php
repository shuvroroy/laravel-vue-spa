<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_a_unique_email()
    {
        $user = factory(User::class)->create([
            'email' => $email = 'john@example.com'
        ]);

        $data = [
            'email' => $email,
        ];

        $this->actingAs($this->user)
            ->json('PATCH', route('profile.update'), $data)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email'
                ]
            ]);
    }

    /** @test */
    public function it_update_profile_info()
    {
        $this->actingAs($this->user)
            ->json('PATCH', route('profile.update'), [
                'name' => $name = 'John Doe',
                'email' => $email = 'john@example.com',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $name,
            'email' => $email,
        ]);
    }
}
