<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_updating_user(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/api/user', [
            'name' => 'Alex',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertOk()
            ->assertJson([
                'id' => $user->id,
                'name' => 'Alex',
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Alex',
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
    }

    public function test_attribute_name_is_required_for_updating_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/api/user', [
            'name' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();
    }

    public function test_attribute_name_is_string_for_updating_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/api/user', [
            'name' => true,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();
    }

    public function test_attribute_password_is_required_for_updating_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/api/user', [
            'name' => 'Alex',
            'password' => '',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();
    }

    public function test_attribute_password_is_string_for_updating_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/api/user', [
            'name' => 'Alex',
            'password' => 12345678,
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();
    }

    public function test_attribute_password_is_confirmed_for_updating_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/api/user', [
            'name' => 'Alex',
            'password' => '12345678',
            'password_confirmation' => '123456789',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();
    }
}
