<?php

namespace Database\Factories;

use App\Models\AimagCity;
use App\Models\BagHoroo;
use App\Models\Reason;
use App\Models\Register;
use App\Models\SoumDistrict;
use App\Models\Status;
use App\Models\User;
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
            'long' => $this->faker->randomDigitNotNull,
            'lat' => $this->faker->randomDigitNotNull,
            'description' => $this->faker->word,
            'resolve_desc' => $this->faker->word,
            'reason_id' => Reason::factory(),
            'status_id' => Status::factory(),
            'aimag_city_id' => AimagCity::factory(),
            'soum_district_id' => SoumDistrict::factory(),
            'bag_horoo_id' => BagHoroo::factory(),
            'address' => $this->faker->word,
            'user_id' => User::factory(),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
