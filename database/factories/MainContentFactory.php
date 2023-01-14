<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MainContent>
 */
class MainContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userId = Arr::random(\App\Models\User::all()->pluck('id')->toArray());
        dump($userId);
        return [
            'section' => fake()->name(),
            'content' => fake()->randomHtml(),
            'image'   => fake()->imageUrl(1920, 1080, null, true, null, false),
            'user_id' => $userId,
        ];
    }
}
