<?php

namespace Database\Factories;

use App\Models\Reason;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReasonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reason::class;

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
        'sub_group' => $this->faker->word,
        'stype' => $this->faker->word,
        'place_id' => $this->faker->word,
        'created_at' => $this->faker->word,
        'updated_at' => $this->faker->word
        ];
    }
}
