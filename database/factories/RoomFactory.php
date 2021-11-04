<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2,1),
            'desc' => $this->faker->paragraph(2),
            'capacity' => $this->faker->numberBetween(20,100),
            'open_at' => $this->faker->numberBetween(7,15).':'.$this->faker->randomElement(['00','15','30']),
            'close_at' => $this->faker->numberBetween(16,22).':'.$this->faker->randomElement(['00','15','30']),
        ];
    }
}
