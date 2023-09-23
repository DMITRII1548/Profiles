<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_storing_a_post(): void
    {
        $this->withExceptionHandling();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($profile->user)->post('api/posts', [
            'title' => 'post title',
            'content' => 'post content',
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'created',
                'post_id'
            ]);


        $post = Post::first();

        $this->assertDatabaseHas('posts', [
            'title' => 'post title',
            'content' => 'post content',
        ]);

        for ($i = 1; $i < 4; $i++) {
            $array[$i - 1] = $i;
            $this->assertDatabaseHas('post_tag', [
                'post_id' => $post->id,
                'tag_id' => $i,
            ]);
        }

        Storage::assertExists($post->path);
    }

    public function test_can_not_create_post_if_profile_does_not_exist()
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'content' => 'post content',
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(500);

        $this->assertDatabaseMissing('posts', [
            'title' => 'post title',
            'content' => 'post content',
        ]);
    }

    public function test_attribute_title_is_required_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'content' => 'post content',
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_title_is_string_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 5,
            'content' => 'post content',
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_content_is_required_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_content_is_string_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'content' => 5,
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_image_is_required_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'content' => 'post content',
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_image_is_file_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'content' => 'post content',
            'image' => 5,
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_image_is_mimes_png_or_jpg_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'content' => 'post content',
            'image' => UploadedFile::fake()->image('test.webp', 300, 300),
            'tags_id' => [
                1, 2, 3
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_tags_id_is_required_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'content' => 'post content',
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
        ]);

        $response->assertStatus(302);
    }

    public function test_attribute_tags_id_is_array_for_storing_post(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        $tags = Tag::factory(3)->create();

        $response = $this->actingAs($user)->post('api/posts', [
            'title' => 'post title',
            'content' => 'post content',
            'image' => UploadedFile::fake()->image('test.png', 300, 300),
            'tags_id' => 1,
        ]);

        $response->assertStatus(302);
    }
}
