<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RoomHourTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreation()
    {
        $this->actingAs(User::find(1));
        $roomHour = \App\Models\RoomHour::factory()->create();
        $rs = $this->put('/room/hour',[
            'room_id' => 1,
            'day' => 1,
            'hour_start' => "20:00",
            "hour_end" => "21:00",
            "capacity" => 10,
            "fail_capacity" => false,
            "bind_hours" => false,
            "prev_confirmation" => false
        ]);
        $rs->seeJson(['status' => 'success']);
        return $roomHour->id;
    }

    /**
     * @depends testCreation
     */
    public function testUpdate($id){
        $this->actingAs(User::find(1));
        $this->patch("/room/hour",[
            'id' => $id,
            "hour_start" => "20:30",
            "hour_end" => "21.30",
            "bind_hours" => false,
            "prev_confirmation" => true
        ])->seeJson(['status' => 'success']);
    }

    /**
     * @depends testCreation
     */
    public function testGet($id){
        $this->actingAs(User::find(1));
        $this->get("/room/hour/".$id)->seeJson(['status' => 'success']);
    }

    /**
     * @depends testCreation
     */
    public function testDelete($id){
        $this->actingAs(User::find(1));
        $this->delete("/room/hour",[
            "id" => $id
        ])->seeJson(['status' => 'success']);
    }
}
