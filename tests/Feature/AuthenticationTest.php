<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);
    }

    public function test_user_cannot_access_protected_route_without_token()
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_protected_route()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/user');
        $response->assertStatus(200);
    }
}
