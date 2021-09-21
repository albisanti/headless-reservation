<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('room_hour_id')->index('foreign_room_hour');
            $table->integer('user_id')->index('foreign_user');
            $table->string('hour_start');
            $table->string('hour_end')->nullable();
            $table->integer('eta')->nullable();
            $table->enum('status',['active','canceled','to_approve']);
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
        Schema::dropIfExists('reservations');
    }
}
