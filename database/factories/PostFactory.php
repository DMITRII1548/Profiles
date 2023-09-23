<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFile = UploadedFile::fake()->image('test.jpg');
        $imagePath = Storage::disk('public')->put('/images', $imageFile);

        $imageUrl = url('/storage' . $imagePath);

        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->text(1000),
            'image_url' => $imageUrl,
            'image_path' => $imagePath,
        ];
    }
}
