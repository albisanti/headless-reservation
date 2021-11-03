<?php

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
        $this->put('/room',[
            'name' => 'UnitTest Room',
            'desc' => 'Testing with phpUnit',
            'capacity' => '20',
            'fail_capacity' => true,
            'default_capacity' => true,
            'open_at' => '08:00',
            'close_at' => '22:00'
        ])->seeJson(['status' => 'success']);
    }

    public function testUpdate(){
        $this->patch('/room',[
            'id' => 1,
            'name' => 'updated Test',
            'capacity' => 30,
            'fail_capacity' => false,
            'close_at' => '22:30'
        ])->seeJson(['status' => 'success']);
    }

    public function testDelete(){
        $this->delete('/room',[
            'id' => 1
        ])->seeJson(['status' => 'success']);
    }

}
