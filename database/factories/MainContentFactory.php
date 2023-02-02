<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Str;

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
        // dump($userId);
        return [
            'section' => fake()->randomDigit(),
            'title'   => Str::title(fake()->words(rand(3, 7), true)),
            'body'    => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/ul/ol/dl/bq/decorate')->body()),
            'image'   => 'https://source.unsplash.com/random/640%C3%97480',
            'user_id' => $userId,
        ];
    }
}
