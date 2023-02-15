<?php

namespace Database\Seeders;

use App\Models\Form;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $media_cat = [
            'landscape',
            'technologies',
            'city',
        ];
        Form::factory(10)->create();
        // Form::factory()->times(25)
        //     ->has(FormQuestion::factory()->count(rand(3, 12)), 'questions')
        //     ->create()->each(function ($item, $key) use ($media_cat) {
        //     $item->media()->create([
        //         'path' => 'https://source.unsplash.com/random?' . Arr::random($media_cat),
        //     ]);
        // });
        Form::all()->random(rand(5, 10))->each(fn($item, $key) => $item->delete());
    }
}
