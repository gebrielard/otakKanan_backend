<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $primaryKey = 'facility_id';
    protected $table = 'facilities';
    protected $fillable = [
        'room_id',
        'user_id',
        'name',
        'status'
    ];
    public $timestamps = true;
}
