<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_hour_id' => 1,
            'user_id' => 1,
            'hour_start' => str_pad($this->faker->numberBetween(0,23),1,'0').':'.str_pad($this->faker->numberBetween(0,60),1,'0').':00',
            'hour_end' => str_pad($this->faker->numberBetween(0,23),1,'0').':'.str_pad($this->faker->numberBetween(0,60),1,'0').':00',
            'eta' => $this->faker->randomDigit(),
            'status' => 'to_approve',
            'date_reserved' => $this->faker->date(),
        ];
    }
}
