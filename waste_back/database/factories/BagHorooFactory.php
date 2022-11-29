<?php

namespace Database\Factories;

use App\Models\BagHoroo;
use App\Models\SoumDistrict;
use Illuminate\Database\Eloquent\Factories\Factory;

class BagHorooFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BagHoroo::class;

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
            'soum_district_id' => SoumDistrict::factory(),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
