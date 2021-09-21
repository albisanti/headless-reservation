<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('room_id');
            $table->integer('day');
            $table->string('hour_start');
            $table->string('hour_end')->nullable();
            $table->integer('max_time')->nullable()->comment('In minutes');
            $table->integer('capacity')->nullable();
            $table->boolean('fail_capacity')->default(false)->comment('Tell the software if it has to fail after the max capacity is reached');
            $table->boolean('bind_hours')->default(false)->comment('Choose if the user can reserve only between the hours');
            $table->boolean('prev_confirmation')->default(true)->comment('Choose if the admin must confirm a reservation');
            $table->enum('status',['enabled','disabled','pend_creation'])->default('pend_creation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms_hours');
    }
}
