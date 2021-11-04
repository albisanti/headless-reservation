<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomHour extends Model
{
    use HasFactory;

    protected $table = "room_hours";
    protected $guarded = [];
}
