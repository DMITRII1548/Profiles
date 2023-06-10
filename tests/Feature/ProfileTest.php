<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_storing_a_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'title for profile',
            'description' => 'description for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('profiles', [
            'title' => 'title for profile',
            'description' => 'description for profile',
        ]);

        Storage::disk('public')->assertExists(Auth::user()->profile->avatar_path);
    }

    public function test_user_can_not_create_second_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'title for profile',
            'description' => 'description for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $seconResponse = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'second title for profile',
            'description' => 'second description for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $seconResponse->assertStatus(500);
    }

    public function test_attribute_title_is_required_for_storing_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'description' => 'description for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_title_is_string_for_storing_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 123,
            'description' => 'description for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_description_is_required_for_storing_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'title for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_description_is_string_for_storing_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'title for profile',
            'description' => 123,
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_image_is_required_for_storing_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'title for profile',
            'description' => 'description for profile',
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_image_is_file_for_storing_profile(): void
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'title for profile',
            'description' => 'description for profile',
            'image' => 123,
        ]);

        $response->assertStatus(302);
    }
}
