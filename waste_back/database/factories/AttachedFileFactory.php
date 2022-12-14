<?php

namespace Database\Factories;

use App\Models\AttachedFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttachedFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttachedFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'register_id' => $this->faker->word,
        'path' => $this->faker->word,
        'type' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
