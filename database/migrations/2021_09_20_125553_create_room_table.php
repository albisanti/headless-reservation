<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name',80);
            $table->string('desc',250)->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('fail_capacity')->default(false)->comment('Tell the software if it has to fail after the max capacity is reached');
            $table->boolean('default_capacity')->default(true)->comment('If an hour does not have a capacity, this capacity will be the default');
            $table->integer('default_price')->default(0)->comment('Default price if no price on room hour');
            $table->time('open_at')->nullable()->comment('When the room opens');
            $table->time('close_at')->nullable()->comment('When the room close');
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
        Schema::dropIfExists('room');
    }
}
