<?php

use App\Models\User;
use \App\Models\Room;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RoomTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreation()
    {
        $this->actingAs(User::find(1));
        $room = Room::factory()->create();
        $this->put('/room',[
            'name' => 'UnitTest Room',
            'desc' => 'Testing with phpUnit',
            'capacity' => '20',
            'fail_capacity' => true,
            'default_capacity' => true,
            'open_at' => '08:00',
            'close_at' => '22:00'
        ])->seeJson(['status' => 'success']);
        return $room->id;
    }

    /**
     * @depends testCreation
     */
    public function testUpdate($id){
        $this->actingAs(User::find(1));
        $this->patch('/room',[
            'id' => $id,
            'name' => 'updated Test',
            'capacity' => 30,
            'fail_capacity' => false,
            'close_at' => '22:30'
        ])->seeJson(['status' => 'success']);
    }

    /**
     * @depends testCreation
     */
    public function testDelete($id){
        $this->actingAs(User::find(1));
        $this->delete('/room',[
            'id' => $id
        ])->seeJson(['status' => 'success']);
    }

}
