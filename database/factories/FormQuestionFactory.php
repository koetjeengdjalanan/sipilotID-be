<?php

namespace Database\Factories;

use App\Models\FormQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormQuestion>
 */
class FormQuestionFactory extends Factory
{
    protected $model = FormQuestion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $availableType = [
            'text',
            'listbox',
            'datetime',
        ];
        return [
            // 'form_id' => '',
            'question' => fake()->words(rand(4, 10), true),
            'order'    => rand(0, 10),
            'type'     => $type = Arr::random($availableType),
            'label'    => ($type === 'text')
            ? json_encode(['label' => fake()->sentence(rand(6, 10), true)])
            : json_encode(['label' => fake()->sentence(rand(6, 10), true), 'value' => fake()->words(rand(3, 7), false)]),
        ];
    }
}
