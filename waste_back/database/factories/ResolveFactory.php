<?php

namespace Database\Factories;

use App\Models\Resolve;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResolveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resolve::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'created_at' => $this->faker->word,
        'updated_at' => $this->faker->word
        ];
    }
}
