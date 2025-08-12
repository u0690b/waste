<?php

namespace Database\Factories;

use App\Models\UsersModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsersModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UsersModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'username' => $this->faker->word,
        'password' => $this->faker->word,
        'aimag_city_id' => $this->faker->word,
        'soum_district_id' => $this->faker->word,
        'bag_horoo_id' => $this->faker->word,
        'phone' => $this->faker->word,
        'place_id' => $this->faker->word,
        'roles' => $this->faker->word,
        'remember_token' => $this->faker->word,
        'push_token' => $this->faker->word,
        'created_at' => $this->faker->word,
        'updated_at' => $this->faker->word,
        'deleted_at' => $this->faker->word
        ];
    }
}
