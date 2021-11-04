<?php

namespace Database\Factories;

use App\Models\RoomHour;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomHourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoomHour::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id' => 1,
            'day' => $this->faker->numberBetween(1,7),
            'hour_start' => str_pad($this->faker->numberBetween(0,23),1,'0').':'.str_pad($this->faker->numberBetween(0,60),1,'0'),
            'hour_end' => str_pad($this->faker->numberBetween(0,23),1,'0').':'.str_pad($this->faker->numberBetween(0,60),1,'0'),
            'max_time' => $this->faker->numberBetween(30,120),
            'capacity' => $this->faker->randomDigit(),
            'fail_capacity' => $this->faker->boolean(),
            'bind_hours' => $this->faker->boolean(),
            'prev_confirmation' => $this->faker->boolean(),
            'price' => $this->faker->randomFloat(2,0,1000),
            'status' => 'enabled',
        ];
    }
}
