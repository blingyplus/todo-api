<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Todo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'details' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(Todo::getAllowedStatuses()),
        ];
    }
}
