<?php

namespace Database\Factories;

use App\Models\SoumDistrict;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoumDistrictFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoumDistrict::class;

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
            'short' => $this->faker->word,
            'aimag_city_id' => $this->faker->word

        ];
    }
}
