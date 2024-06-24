<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nb = random_int(5, 10);
        $title = $this->faker->sentence($nb, false);
        return [
            'title' => $title,
            'slug' => SlugIt($title),
            'content' => $this->faker->paragraphs($nb, true),
            'imagesPath' => $this->faker->imageUrl(400, 400),
        ];
    }
}

function SlugIt($data)
{
    $slug = Str::slug($data);
    return $slug;
}
