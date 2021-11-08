<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ReservationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return array
     */
    public function testCreation()
    {
        $this->actingAs(User::find(1));
        $room = \App\Models\Room::factory()->create();
        $hour = \App\Models\RoomHour::factory()->create([
            'room_id' => $room->id
        ]);
        $reservation = \App\Models\Reservation::factory()->create([
            'room_hour_id' => $hour->id
        ]);
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
        return array('reservation' => $reservation->id, 'hour' => $hour->id, 'room' => $room->id);
    }

    public function testGetAllReservations(){
        $this->actingAs(User::find(1));
        $this->get('/reservations')->seeJson(['status' => 'success']);
    }

    /**
     * @depends testCreation
     */
    public function testGetRoomsReservations($ids){
        $this->actingAs(User::find(1));
        $this->get('/reservation/room/'.$ids['room'])->seeJson(['status' => 'success']);
    }

    public function testGetMyReservations(){
        $this->actingAs(User::find(2));
        $this->get('/reservation/mine')->seeJson(['status' => 'success']);

    }

    public function testGetUserReservations(){
        $this->actingAs(User::find(1));
        $this->get('/reservation/user/1')->seeJson(['status' => 'success']);
    }

    /**
     * @depends testCreation
     */
    public function testUpdateStatusReservation($ids){
        $this->actingAs(User::find(1));
        $this->patch('/reservation/confirm/'.$ids['reservation'])->seeJson(['status' => 'success']);
        $this->patch('/reservation/refuse/'.$ids['reservation'])->seeJson(['status' => 'success']);
        $this->actingAs(User::find(2));
        $this->patch('/reservation/confirm/'.$ids['reservation'])->seeJson(['status' => 'error']);
    }

    /**
     * @depends testCreation
     */
    public function testDeleteReservation($ids){
        $this->actingAs(User::find(1));
        $this->delete('/reservation/'.$ids['reservation'])->seeJson(['status' => 'success']);
    }

}
