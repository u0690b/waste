<?php

namespace Database\Factories;

use App\Models\AimagCity;
use Illuminate\Database\Eloquent\Factories\Factory;

class AimagCityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AimagCity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
        'name' => $this->faker->word,
        'created_at' => $this->faker->word,
        'updated_at' => $this->faker->word
        ];
    }
}
