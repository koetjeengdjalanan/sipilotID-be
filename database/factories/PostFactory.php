<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
    public function definition()
    {
        $title    = fake()->unique()->words(rand(3, 7), true);
        $author   = Arr::random(\App\Models\User::all()->pluck('id')->toArray());
        $category = Arr::random(\App\Models\Category::all()->pluck('id')->toArray());
        return [
            'title'          => $title,
            'slug'           => Str::slug($title),
            'user_id'        => $author,
            'category_id'    => $category,
            'excerpt'        => fake()->sentences(25, true),
            'body'           => fake()->randomHtml(5, 10),
            'published_date' => (rand(1, 9) > 3) ? fake()->dateTimeBetween('-2 months', 'now') : null,
        ];
    }
}
