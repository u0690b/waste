<?php

namespace Database\Factories;

use App\Models\RegisterHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegisterHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RegisterHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'register_id' => $this->faker->word,
        'long' => $this->faker->randomDigitNotNull,
        'lat' => $this->faker->randomDigitNotNull,
        'description' => $this->faker->word,
        'resolve_desc' => $this->faker->word,
        'reason_id' => $this->faker->word,
        'status_id' => $this->faker->word,
        'aimag_city_id' => $this->faker->word,
        'soum_district_id' => $this->faker->word,
        'bag_horoo_id' => $this->faker->word,
        'address' => $this->faker->word,
        'user_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
