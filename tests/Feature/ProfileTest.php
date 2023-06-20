<?php

namespace Tests\Feature;

use App\Http\Resources\Profile\ProfileResource;
use App\Models\Profile;
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

        Storage::fake('public');

        $user = User::factory()->create();

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
        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/profiles', [
            'title' => 'title for profile',
            'description' => 'description for profile',
            'image' => 123,
        ]);

        $response->assertStatus(302);
    }

    public function test_showing_profile_of_current_user(): void
    {
        $this->withExceptionHandling();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->get('/api/profiles/show');

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'title',
                'avatar_url',
                'description',
            ])
            ->assertJson(
                ProfileResource::make($profile)->resolve()
            );
    }

    public function test_showing_not_exist_auth_user_profile(): void
    {
        $this->withExceptionHandling();

        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/profiles/show');

        $response->assertStatus(204);
    }

    public function test_showing_any_profiles_for_any_users(): void
    {
        $this->withExceptionHandling();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->get('/api/profiles/' . $profile->id);

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'title',
                'avatar_url',
                'description',
            ])
            ->assertJson(
                ProfileResource::make($profile)->resolve()
            );
    }

    public function test_destroying_a_profile(): void
    {
        $this->withExceptionHandling();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->delete('/api/profiles');

        $response->assertOk()
            ->assertJson([
                'deleted' => true,
            ]);

        $this->assertDatabaseMissing('profiles', [
            'id' => $profile->id,
        ]);

        Storage::assertMissing($profile->path);
    }

    public function test_updating_a_profile_with_image(): void
    {
        $this->withExceptionHandling();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->patch('/api/profiles', [
            'title' => 'updating title',
            'description' => 'updating description',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertOk()
            ->assertJson([
                'updated' => true
            ]);

        $this->assertDatabaseMissing('profiles', $profile->toArray())
            ->assertDatabaseHas('profiles', [
                'title' => 'updating title',
                'description' => 'updating description',
            ]);

        Storage::disk('public')->assertMissing($profile->avatar_path);
        Storage::disk('public')->assertExists(
            Auth::user()
                ->profile
                ->avatar_path
        );
    }

    public function test_updating_a_profile_without_image(): void
    {
        $this->withExceptionHandling();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->patch('/api/profiles', [
            'title' => 'updating title',
            'description' => 'updating description',
            'image' => null,
        ]);

        $response->assertOk()
            ->assertJson([
                'updated' => true
            ]);

        $this->assertDatabaseMissing('profiles', $profile->toArray())
            ->assertDatabaseHas('profiles', [
                'title' => 'updating title',
                'description' => 'updating description',
            ]);
    }

    public function test_attribute_title_is_required_for_updating_profile(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->patch('/api/profiles', [
            'description' => 'description for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_title_is_string_for_updating_profile() : void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->patch('/api/profiles', [
            'title' => true,
            'description' => 'description for profile',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_description_is_required_for_updating_profile(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->patch('/api/profiles', [
            'title' => 'updating title',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_description_is_string_for_updating_profile(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->patch('/api/profiles', [
            'title' => 'updating title',
            'description' => true,
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_image_can_be_null_for_updating_profile()
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->patch('/api/profiles', [
            'title' => 'updating title',
            'description' => 'updating description',
            'image' => null,
        ]);

        $response->assertStatus(200);
    }

    public function test_attribute_image_can_be_image_for_updating_profile()
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->patch('/api/profiles', [
            'title' => 'updating title',
            'description' => 'updating description',
            'image' => UploadedFile::fake()->image('post.jpg'),
        ]);

        $response->assertStatus(200);
    }

    public function test_attribute_image_is_null_or_image_for_updating_profile()
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $response = $this->actingAs($profile->user)->patch('/api/profiles', [
            'title' => 'updating title',
            'description' => 'updating description',
            'image' => 'image',
        ]);

        $response->assertStatus(302);
    }
}
