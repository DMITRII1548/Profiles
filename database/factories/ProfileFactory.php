<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePath = '/images/' . $this->faker->image('public/storage/images', 640, 480, null, false);

        $imageUrl = url('/storage' . $imagePath);

        return [
            'title' => $this->faker->jobTitle,
            'avatar_url' => $imageUrl,
            'avatar_path' => $imagePath,
            'description' => $this->faker->text(),
        ];
    }
}
