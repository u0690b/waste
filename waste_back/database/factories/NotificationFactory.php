<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
        'type' => $this->faker->word,
        'title' => $this->faker->word,
        'content' => $this->faker->text,
        'read_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
