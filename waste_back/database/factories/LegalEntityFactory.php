<?php

namespace Database\Factories;

use App\Models\LegalEntity;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegalEntityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LegalEntity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'register' => $this->faker->word,
        'name' => $this->faker->word,
        'industry_id' => $this->faker->word
        ];
    }
}
