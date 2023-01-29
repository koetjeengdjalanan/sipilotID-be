<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormQuestion;
use App\Models\Submission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

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
        Form::factory()->times(25)
            ->has(FormQuestion::factory()->count(rand(3, 12))->has(Submission::factory()->count(rand(10, 30)), 'answers'), 'questions')
            ->create()->each(function ($item, $key) use ($media_cat) {
            $item->media()->create([
                'path' => 'https://source.unsplash.com/random?' . Arr::random($media_cat),
            ]);
        });
        Form::all()->random(rand(5, 10))->each(fn($item, $key) => $item->delete());
    }
}
