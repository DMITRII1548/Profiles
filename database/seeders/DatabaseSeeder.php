<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();



        Profile::factory()
            ->for(\App\Models\User::factory()->state([
                'name' => 'user',
                'email' => 'user@gmail.com',
            ]))
            ->create();
    }
}
