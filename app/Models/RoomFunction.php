<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFunction extends Model
{
    use HasFactory;

    protected $primaryKey = 'room_function_id';
    protected $table = 'room_functions';
    protected $fillable = [
        'room_id',
        'name'
    ];
    public $timestamps = true;
}