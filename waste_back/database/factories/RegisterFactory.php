<?php

namespace Database\Factories;

use App\Models\Register;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegisterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Register::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'whois' => $this->faker->word,
        'name' => $this->faker->word,
        'register' => $this->faker->word,
        'chiglel' => $this->faker->word,
        'aimag_city_id' => $this->faker->word,
        'soum_district_id' => $this->faker->word,
        'bag_horoo_id' => $this->faker->word,
        'address' => $this->faker->word,
        'description' => $this->faker->word,
        'reason_id' => $this->faker->word,
        'zuil_zaalt' => $this->faker->word,
        'long' => $this->faker->word,
        'lat' => $this->faker->word,
        'reg_user_id' => $this->faker->word,
        'resolve_id' => $this->faker->word,
        'resolve_desc' => $this->faker->word,
        'resolve_image' => $this->faker->word,
        'resolved_at' => $this->faker->word,
        'comf_user_id' => $this->faker->word,
        'status_id' => $this->faker->word,
        'reg_at' => $this->faker->word,
        'allocate_by' => $this->faker->word,
        'created_at' => $this->faker->word,
        'updated_at' => $this->faker->word
        ];
    }
}
