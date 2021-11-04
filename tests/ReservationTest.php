<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ReservationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreation()
    {
        $this->actingAs(User::find(1));
        $reservation = \App\Models\Reservation::factory()->create();
        $rs = $this->put('/reservation',[
            'room_hour_id' => $reservation->room_hour_id,
            'user_id' => $reservation->user_id,
            'hour_start' => $reservation->hour_start,
            'hour_end' => $reservation->hour_end,
            'eta' => $reservation->eta,
            'status' => $reservation->status,
            'date_reserved' => $reservation->date_reserved,
        ]);
        $rs->seeJson(['status' => 'success']);
        return $reservation->id;
    }

    public function testGetRoomsReservations(){
        $this->actingAs(User::find(1));
        //reservation/room
        $this->get('/reservation/room/1')->seeJson(['status' => 'success']);
    }

    public function testGetMyReservations(){
        $this->actingAs(User::find(1));
        //reservation/mine
        $this->get('/reservation/mine')->seeJson(['status' => 'success']);

    }

    public function testGetUserReservations(){
        $this->actingAs(User::find(1));
        //reservation/user/{id}
        $this->get('/reservation/user/1')->seeJson(['status' => 'success']);

    }
}
