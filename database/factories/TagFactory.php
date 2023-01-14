<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title  = fake()->unique()->words(rand(1, 2), true);
        $author = Arr::random(\App\Models\User::all()->pluck('id')->toArray());
        return [
            'title'   => $title,
            'slug'    => Str::slug($title),
            'user_id' => $author,
        ];
    }
}
