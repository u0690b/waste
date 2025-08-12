<?php

namespace Database\Factories;

use App\Models\AimagCity;
use App\Models\BagHoroo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $bagHoroo = BagHoroo::whereIn('soum_district_id', [148, 149, 150, 151, 152, 153, 154, 155, 156])->inRandomOrder()->first();
        $bagHoroo = BagHoroo::whereIn('soum_district_id', [150])->inRandomOrder()->first();
        return [
            'name' => $this->faker->word,
            'username' => $this->faker->word,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'aimag_city_id' => $bagHoroo->soum_district->aimag_city_id,
            'soum_district_id' => $bagHoroo->soum_district_id,
            'bag_horoo_id' => $bagHoroo,
            'roles' => $this->faker->text,
            'place_id' => random_int(1, 9),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
