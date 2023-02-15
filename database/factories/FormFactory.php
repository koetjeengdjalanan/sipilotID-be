<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form>
 */
class FormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title       = fake()->unique()->words(rand(3, 7), true);
        $publish     = fake()->dateTimeInInterval('-1 months', '+3 months');
        $description = fake()->paragraph(rand(3, 5));
        return [
            'title'        => Str::title($title),
            'slug'         => 'https://form.sipilot.id/index.php/' . fake()->numberBetween(10000, 99999) . '?lang=id',
            'user_id'      => User::all()->random()->id,
            'description'  => $description,
            'excerpt'      => Str::excerpt($description),
            'publish_date' => $publish,
            'expire'       => fake()->dateTimeBetween($publish, Carbon::parse($publish)->addWeeks(rand(1, 8))),
        ];
    }
}
