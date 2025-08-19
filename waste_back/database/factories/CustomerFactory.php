<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'regnum' => $this->faker->word,
            'firstname' => $this->faker->word,
            'gender' => $this->faker->word,
            'image' => $this->faker->text,
            'lastname' => $this->faker->word,
            'nationality' => $this->faker->word,
            'passportAddress' => $this->faker->word,
            'passportExpireDate' => $this->faker->word,
            'passportIssueDate' => $this->faker->word,
            'soumDistrictCode' => $this->faker->word,
            'soumDistrictName' => $this->faker->word,
            'surname' => $this->faker->word,
            'token' => $this->faker->word,
            'remember_token' => $this->faker->word,
            'push_token' => $this->faker->word,
            'created_at' => $this->faker->word,
            'updated_at' => $this->faker->word
        ];
    }
}
