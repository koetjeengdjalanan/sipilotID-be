<?php

namespace Database\Seeders;

use App\Models\MainContent;
use App\Models\User;
use Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MainContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = MainContent::insert([
            [
                'id'      => fake()->uuid,
                'user_id' => User::first()->id,
                'section' => 1,
                'title'   => Str::title(fake()->words(rand(4, 9), true)),
                'image'   => 'https://source.unsplash.com/random/640%C3%97480',
                'content' => json_encode([
                    'body' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/ul/ol/dl/bq/decorate')->body()),
                ]),
            ],
            [
                'id'      => fake()->uuid,
                'user_id' => User::first()->id,
                'section' => 2,
                'title'   => Str::title(fake()->words(rand(4, 9), true)),
                'image'   => 'https://source.unsplash.com/random/640%C3%97480',
                'content' => json_encode([
                    'body' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/4/short/link/ul/ol/dl/bq/decorate')->body()),
                ]),
            ],
            [
                'id'      => fake()->uuid,
                'user_id' => User::first()->id,
                'section' => 3,
                'title'   => Str::title(fake()->words(rand(4, 9), true)),
                'image'   => 'https://source.unsplash.com/random/640%C3%97480',
                'content' => json_encode([
                    'body' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/4/short/link/ul/ol/dl/bq/decorate')->body()),
                ]),
            ],
            [
                'id'      => fake()->uuid,
                'user_id' => User::first()->id,
                'section' => 4,
                'title'   => Str::title(fake()->words(rand(4, 9), true)),
                'image'   => 'https://source.unsplash.com/random/640%C3%97480',
                'content' => json_encode([
                    'body'   => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/4/short/link/ul/ol/dl/bq/decorate')->body()),
                    'report' => [
                        'point'       => fake()->numberBetween(10, 99) . fake()->randomLetter(),
                        'description' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/decorate')->body()),
                    ], [
                        'point'       => fake()->numberBetween(10, 99) . fake()->randomLetter(),
                        'description' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/decorate')->body()),
                    ], [
                        'point'       => fake()->numberBetween(10, 99) . fake()->randomLetter(),
                        'description' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/decorate')->body()),
                    ],
                ]),
            ],
            [
                'id'      => fake()->uuid,
                'user_id' => User::first()->id,
                'section' => 5,
                'title'   => Str::title(fake()->words(rand(4, 9), true)),
                'image'   => 'https://source.unsplash.com/random/640%C3%97480',
                'content' => json_encode([
                    'body'     => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/4/short/link/ul/ol/dl/bq/decorate')->body()),
                    'offering' => [
                        'icon'        => Arr::random(['pi-chart-pie', 'pi-bookmark', 'pi-apple', 'pi-thumbs-up']),
                        'description' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/decorate')->body()),
                    ], [
                        'icon'        => Arr::random(['pi-chart-pie', 'pi-bookmark', 'pi-apple', 'pi-thumbs-up']),
                        'description' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/decorate')->body()),
                    ], [
                        'icon'        => Arr::random(['pi-chart-pie', 'pi-bookmark', 'pi-apple', 'pi-thumbs-up']),
                        'description' => str_replace(array("\t", "\n"), '', Http::get('https://loripsum.net/api/2/short/link/decorate')->body()),
                    ],
                ]),
            ],
            [
                'id'      => fake()->uuid,
                'user_id' => User::first()->id,
                'section' => 6,
                'title'   => Str::title(fake()->words(rand(4, 9), true)),
                'image'   => 'https://source.unsplash.com/random/640%C3%97480',
                'content' => json_encode([
                    [
                        'message' => fake()->sentences(rand(2, 4), true),
                        'client'  => [
                            'name'      => fake()->name(),
                            'avatarUrl' => 'https://source.unsplash.com/random/640%C3%97480',
                            'jobTitle'  => fake()->jobTitle(),
                        ],
                    ],
                    [
                        'message' => fake()->sentences(rand(2, 4), true),
                        'client'  => [
                            'name'      => fake()->name(),
                            'avatarUrl' => 'https://source.unsplash.com/random/640%C3%97480',
                            'jobTitle'  => fake()->jobTitle(),
                        ],
                    ],
                    [
                        'message' => fake()->sentences(rand(2, 4), true),
                        'client'  => [
                            'name'      => fake()->name(),
                            'avatarUrl' => 'https://source.unsplash.com/random/640%C3%97480',
                            'jobTitle'  => fake()->jobTitle(),
                        ],
                    ],
                ]),
            ],
        ]);
    }
}
