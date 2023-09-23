<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use Database\Factories\TagFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();



        $profile = Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();

        Post::factory(5)
            ->hasAttached(
                Tag::factory()->count(3)
            )
            ->create([
                'profile_id' => $profile->id
            ]);
    }
}
